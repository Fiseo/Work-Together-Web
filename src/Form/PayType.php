<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class PayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'label'       => 'Numéro de carte',
                'attr'        => [
                    'placeholder' => '1234 5678 9012 3456',
                    'maxlength'   => 19,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le numéro de carte est obligatoire.']),
                    new CardScheme([
                        'schemes' => ['VISA', 'MASTERCARD', 'AMEX'],
                        'message' => 'Le numéro de carte n\'est pas valide.',
                    ]),
                ],
            ])

            ->add('name', TextType::class, [
                'label' => 'Nom Prénom sur la carte',
                'attr'  => [
                    'placeholder' => 'Jean Dupont',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire.']),
                    new Regex([
                        'pattern' => '/^[a-zA-ZÀ-ÿ\s\-]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres.',
                    ]),
                ],
            ])

            ->add('cvv', TextType::class, [
                'label' => 'CVV',
                'attr'  => [
                    'placeholder' => '123',
                    'maxlength'   => 4,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le CVV est obligatoire.']),
                    new Length([
                        'min'        => 3,
                        'max'        => 4,
                        'minMessage' => 'Le CVV doit contenir au moins {{ limit }} chiffres.',
                        'maxMessage' => 'Le CVV doit contenir au plus {{ limit }} chiffres.',
                    ]),
                    new Regex([
                        'pattern' => '/^\d{3,4}$/',
                        'message' => 'Le CVV ne doit contenir que des chiffres.',
                    ]),
                ],
            ])

            ->add('expiry', TextType::class, [
                'label'  => 'Date d\'expiration',
                'mapped' => false,           // champ virtuel, à splitter manuellement si besoin
                'attr'   => [
                    'placeholder' => 'MM/AA',
                    'maxlength'   => 5,
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La date d\'expiration est obligatoire.']),
                    new Regex([
                        'pattern' => '/^(0[1-9]|1[0-2])\/(\d{2})$/',
                        'message' => 'Format invalide. Utilisez MM/AA.',
                    ]),
                ],
            ])

            ->add('consent', CheckboxType::class, [
                'label'       => 'Consentement paiement',
                'required'    => true,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter le consentement de paiement.']),
                ],
            ])

            ->add('retractation', CheckboxType::class, [
                'label'       => 'Droit de rétractation légal',
                'required'    => true,
                'constraints' => [
                    new IsTrue(['message' => 'Vous devez accepter le droit de rétractation.']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
