<?php

namespace App\Form;

use App\Entity\Civility;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur :',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe :',
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(
                        message: 'Please enter a password',
                    ),
                    new Length(
                        min: 6,
                        minMessage: 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        max: 4096,
                    ),
                ],
            ])
            ->add('isCompany', CheckboxType::class, [
                'label' => 'Êtes vous une entreprise ? :',
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom :',
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
                'required' => false,
            ])
            ->add('civility', EntityType::class, [
                'label' => 'Civilité :',
                'class' => Civility::class,
                'choice_label' => 'label',
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'Date de naissance :',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom de l\'entreprise:',
                'required' => false,
            ])
            ->add('companyRegister', TextType::class, [
                'label' => 'Numéro de SIRET :',
                'required' => false,
            ])
            ->add('creationDate', DateType::class, [
                'label' => 'Date de création :',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }
}
