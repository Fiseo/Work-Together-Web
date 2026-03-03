<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'constraints' => [
                    new CardScheme([
                        'schemes' => ['VISA', 'MASTERCARD', 'AMEX'],
                    ]),
                    new NotBlank()
                ],
            ])
            ->add('expiryMonth', ChoiceType::class, [
                'choices'     => array_combine(
                    ['01','02','03','04','05','06','07','08','09','10','11','12'],
                    ['01','02','03','04','05','06','07','08','09','10','11','12']
                ),
                'placeholder' => 'MM',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('expiryYear', ChoiceType::class, [
                'choices'     => array_combine(
                    range(date('Y'), (int)date('Y') + 10),
                    range(date('Y'), (int)date('Y') + 10)
                ),
                'placeholder' => 'AA',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('cvv', TextType::class, [
                'constraints' => [
                    new Length(['min' => 3, 'max' => 4]),
                    new Regex(['pattern' => '/^\d{3,4}$/']),
                    new NotBlank()
                ],
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
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
