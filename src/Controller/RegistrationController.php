<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Individual;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends ModelController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        Security                    $security,
        EntityManagerInterface      $em,
        ValidatorInterface          $validator): Response
    {
        if ($this->isConnected())
            return $this->kick(sendMessage: false);

        $form = $this->createForm(RegistrationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var bool $isCompany*/
            $isCompany = $form->get('isCompany')->getData();

            if ($isCompany) {
                $user = new Company();
                $user->setName($form->get('name')->getData());
                $user->setCompanyRegister($form->get('companyRegister')->getData());
                $user->setCreation($form->get('creationDate')->getData());
            } else {
                $user = new Individual();
                $user->setFirstName($form->get('firstName')->getData());
                $user->setLastName($form->get('lastName')->getData());
                $user->setCivility($form->get('civility')->getData());
                $user->setBirthDate($form->get('birthDate')->getData());
            }

            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());

            //region password
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));
            //endregion

            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->addFlash(
                        'error',
                        $error->getMessage()
                    );
                }
            } else {
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                    'success',
                    'Votre compte a bien été créé.'
                );
                return $security->login($user, 'form_login', 'main');
            }
        }

        foreach ($form->getErrors(true) as $error) {
            $this->addFlash(
                'error',
                $error->getMessage()
            );
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}
