<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use App\Service\UnitService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $offer = $options['offerAvailable'];
        $builder
            ->add('offer', EntityType::class, [
                'class' => Offer::class,
                'choice_label' => 'label',
                'choices' => $offer
            ])
            ->add('isMonthly', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('offerAvailable');
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
