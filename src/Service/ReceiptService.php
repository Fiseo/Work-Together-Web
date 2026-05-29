<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Company;
use App\Entity\Individual;
use App\Entity\Price;
use App\Entity\Receipt;
use App\Repository\PriceRepository;
use App\Repository\ReceiptRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReceiptService
{
    private const TVA_RATE = 20;

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly ReceiptRepository $receiptRepository,
        private readonly PriceRepository $priceRepository,
    ) {}

    public function createReceipt(Booking $booking): Receipt
    {
        $client = $booking->getClient();
        $price = $this->priceRepository->findCurrent();


        if ($client instanceof Company) {
            $nom   = $client->getName();
            $siret = $client->getCompanyRegister();
        } else {
            $nom   = $client->getLastName() . ' ' . $client->getFirstName();
            $siret = null;
        }

        // --- Calcul des montants (en centimes) ---
        $ht  = $price->getValue();
        $tva = (int) round($ht * self::TVA_RATE / 100);
        $ttc = $ht + $tva;

        $start = new \DateTime();
        $end   = (clone $start)->modify($booking->isMonthly() ? '+1 month' : '+1 year');

        // --- Construction du Receipt ---
        $receipt = (new Receipt())
            ->setInvoiceNumber($this->generateInvoiceNumber(new \DateTime()))
            ->setCreation(new \DateTime())
            ->setBooking($booking)
            ->setName($nom)
            ->setCompanyRegister($siret)
            ->setTotalHT($ht)
            ->setTotalTva($tva)
            ->setTotalTtc($ttc)
            ->setStartPeriod($start)
            ->setEndPeriod($end)
            ->setPrice($price);

        $this->em->persist($receipt);
        $this->em->flush();

        return $receipt;
    }

    public function createReceiptFromDate(Booking $booking, \DateTime $date): Receipt
    {
        $client = $booking->getClient();
        $price = $this->priceRepository->findByDate($date);


        if ($client instanceof Company) {
            $nom   = $client->getName();
            $siret = $client->getCompanyRegister();
        } else {
            $nom   = $client->getLastName() . ' ' . $client->getFirstName();
            $siret = null;
        }

        // --- Calcul des montants (en centimes) ---
        $ht  = $price->getValue();
        $tva = (int) round($ht * self::TVA_RATE / 100);
        $ttc = $ht + $tva;

        $start = $date;
        $end   = (clone $start)->modify($booking->isMonthly() ? '+1 month' : '+1 year');

        // --- Construction du Receipt ---
        $receipt = (new Receipt())
            ->setInvoiceNumber($this->generateInvoiceNumber($date))
            ->setCreation(new \DateTime())
            ->setBooking($booking)
            ->setName($nom)
            ->setCompanyRegister($siret)
            ->setTotalHT($ht)
            ->setTotalTva($tva)
            ->setTotalTtc($ttc)
            ->setStartPeriod($start)
            ->setEndPeriod($end)
            ->setPrice($price);

        $this->em->persist($receipt);
        $this->em->flush();

        return $receipt;
    }

    public function createReceiptsForBooking(Booking $booking): array
    {
        $current = clone $booking->getStart();
        $end     = $booking->getEnd();
        $receipts = [];

        while ($current < $end) {
            $alreadyExists = $booking->getReceipts()->exists(
                fn(int $k, Receipt $r) => $r->getStartPeriod()->format('Y-m-d') === $current->format('Y-m-d')
            );

            if (!$alreadyExists) {
                $receipts[] = $this->createReceiptFromDate($booking, clone $current);
            }

            $current->modify($booking->isMonthly() ? '+1 month' : '+1 year');
        }

        return $receipts;
    }

    private function generateInvoiceNumber(\DateTime $dateTime): string
    {
        $prefix = ($dateTime)->format('Ym');

        $count = $this->receiptRepository->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->where('r.invoice_number LIKE :prefix')
            ->setParameter('prefix', $prefix . '%')
            ->getQuery()
            ->getSingleScalarResult();

        return $prefix . str_pad((int) $count + 1, 4, '0', STR_PAD_LEFT);
    }

    public function generatePdf(Receipt $receipt): string
    {
        $options = new Options();
        $options->set('defaultFont', 'Helvetica');
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($this->buildHtml($receipt));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Retourne le contenu binaire du PDF
        return $dompdf->output();
    }

    private function buildHtml(Receipt $receipt): string
    {
        $siret   = $receipt->getCompanyRegister() ? '<p><strong>SIRET :</strong> ' . $receipt->getCompanyRegister() . '</p>' : '';
        $tvaRate = ReceiptService::TVA_RATE; // 20

        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <style>
                body        { font-family: Helvetica, Arial, sans-serif; font-size: 13px; color: #333; margin: 40px; }
                h1          { font-size: 24px; color: #1a1a2e; margin-bottom: 4px; }
                .subtitle   { color: #888; font-size: 12px; margin-bottom: 40px; }
                .row        { display: flex; justify-content: space-between; margin-bottom: 40px; }
                .block      { width: 48%; }
                .block h3   { font-size: 11px; text-transform: uppercase; color: #888; border-bottom: 1px solid #ddd; padding-bottom: 4px; margin-bottom: 8px; }
                table       { width: 100%; border-collapse: collapse; margin-top: 30px; }
                th          { background: #1a1a2e; color: #fff; padding: 10px 12px; text-align: left; font-size: 12px; }
                td          { padding: 10px 12px; border-bottom: 1px solid #eee; }
                .right      { text-align: right; }
                .total-box  { margin-top: 20px; float: right; width: 280px; }
                .total-row  { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #eee; }
                .total-ttc  { font-size: 16px; font-weight: bold; color: #1a1a2e; border-top: 2px solid #1a1a2e; padding-top: 8px; }
                .footer     { margin-top: 80px; font-size: 11px; color: #aaa; text-align: center; border-top: 1px solid #eee; padding-top: 12px; }
            </style>
        </head>
        <body>

            <h1>FACTURE</h1>
            <p class="subtitle">N° {$receipt->getInvoiceNumber()} — émise le {$receipt->getCreation()->format('d/m/Y')}</p>

            <div class="row">
                <div class="block">
                    <h3>Client</h3>
                    <p><strong>{$receipt->getName()}</strong></p>
                    {$siret}
                </div>
                <div class="block" style="text-align:right">
                    <h3>Période facturée</h3>
                    <p>Du <strong>{$receipt->getStartPeriod()->format('d/m/Y')}</strong>
                       au <strong>{$receipt->getEndPeriod()->format('d/m/Y')}</strong></p>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th class="right">Montant HT</th>
                        <th class="right">TVA ({$tvaRate} %)</th>
                        <th class="right">Montant TTC</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{$receipt->getBooking()->getLabel()}</td>
                        <td class="right">{$receipt->getTotalHT()} €</td>
                        <td class="right">{$receipt->getTotalTva()} €</td>
                        <td class="right">{$receipt->getTotalTtc()} €</td>
                    </tr>
                </tbody>
            </table>

            <div class="total-box">
                <div class="total-row"><span>Total HT | </span><span>{$receipt->getTotalHT()} €</span></div>
                <div class="total-row"><span>TVA ({$tvaRate} %) | </span><span>{$receipt->getTotalTva()} €</span></div>
                <div class="total-row total-ttc"><span>Total TTC</span><span>{$receipt->getTotalTtc()} €</span></div>
            </div>

            <div class="footer">
                Facture générée le {$receipt->getCreation()->format('d/m/Y')} — Référence {$receipt->getInvoiceNumber()}
            </div>

        </body>
        </html>
        HTML;
    }
}
