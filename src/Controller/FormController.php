<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Adress;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\RegistrationFormType;
use App\Form\AdressFormType;

class FormController extends AbstractController
{
    #[Route('/formadress', name: 'app_formadress')]
    public function form(AdressFormType $formAdress,Request $request,EntityManagerInterface $entityManager): Response
    {
        //verif id user exist
        $userid = $this->getUser()->getId();
        if ($userid)
        {
            //Create Form Type
            $newAdress = new Adress;
            $formAdress = $this->createForm(AdressFormType::class,$newAdress); 
            $formAdress->handleRequest($request);
                //Create New Adress
                if ($formAdress->isSubmitted() && $formAdress->isValid()) {
                    //Check user exist
                    $user_found = $formAdress->get('users')->getData();
                    //Verif User login == User request form
                    if ($user_found->getId() === $userid) {
                        /** @var Adress $Adress */
 
                        $data = $formAdress->getData();
                        $message = $data;

                        $entityManager->persist($message);
                        $entityManager->flush();
                        $this->addFlash('success', 'Votre Adresse a été mis à jour');
                        return $this->redirectToRoute('app_profile');
                    }
                }
            }
    }
    #[Route('/formadress_cmd', name: 'app_formadress_cmd')]
    public function formadress(AdressFormType $formAdress,Request $request,EntityManagerInterface $entityManager): Response
    {
        //verif id user exist
        $userid = $this->getUser()->getId();
        if ($userid)
        {
            //Create Form Type
            $newAdress = new Adress;
            $formAdress = $this->createForm(AdressFormType::class,$newAdress); 
            $formAdress->handleRequest($request);
                //Create New Adress
                if ($formAdress->isSubmitted() && $formAdress->isValid()) {
                    //Check user exist
                    $user_found = $formAdress->get('users')->getData();
                    //Verif User login == User request form
                        /** @var Adress $Adress */
                        $data = $formAdress->getData();
                        $message = $data;

                        $entityManager->persist($message);
                        $entityManager->flush();
                        $this->addFlash('success', 'Votre Adresse a été ajouté');
                        return $this->redirectToRoute('app_commande');
                    }
                
        }
    }

    #[Route('/formuser', name: 'app_formuser')]
    public function formuser(RegistrationFormType $formUser,AuthenticationUtils $authenticationUtils,Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): Response
    {
        //verif id user exist
        $userid = $this->getUser()->getId();
        if ($userid)
        {
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();
            $identifiant = $this->getUser()->getUserIdentifier();
            // Create Form
            $formUser = $this->createForm(RegistrationFormType::class, $this->getUser());
            $formUser->handleRequest($request);
                //Form submitted and valid check
                if ($formUser->isSubmitted() && $formUser->isValid()) {
                    /** @var Users $users */                    
                    // if (null !== $plainPassword) {
                    //     $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
                    // }
                    $entityManager->flush();
                    $this->addFlash('success', 'Votre profil a été mis à jour');
                    return $this->redirectToRoute('app_profile');
                }
        }
        
    }
}
