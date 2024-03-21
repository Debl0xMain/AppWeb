<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Security\AppCustomAuthenticator;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;



class PageController extends AbstractController
{

    private $userRepo;
    private $AdressRepo;

    public function __construct(UsersRepository $userRepo,AdressRepository $AdressRepo){
        $this->userRepo = $userRepo;
        $this->AdressRepo = $AdressRepo;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('page/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/profil', name: 'app_profile')]
    public function profile(RegistrationFormType $formUser,AdressFormType $formAdress,AuthenticationUtils $authenticationUtils,Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): Response
    {
        $userid = $this->getUser()->getId();
        if ($userid)
        {
            $error = $authenticationUtils->getLastAuthenticationError();
            $lastUsername = $authenticationUtils->getLastUsername();
            $identifiant = $this->getUser()->getUserIdentifier();
            $formUser = $this->createForm(RegistrationFormType::class, $this->getUser());
            $formUser->handleRequest($request);

                if ($formUser->isSubmitted() && $formUser->isValid()) {
                    /** @var Users $users */                    
                    // if (null !== $plainPassword) {
                    //     $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
                    // }
                    $entityManager->flush();
                    $this->addFlash('success', 'Votre profil a été mis à jour');
                    return $this->redirectToRoute('app_profile');
                }

            $adress_user_selected = $this->AdressRepo->findBy(array('users' => $userid));

                if($request->isXmlHttpRequest()) {

                    $userid = $this->getUser()->getId();
                    $idform = $request->request->get('setform');
                    $adress_ajax = $this->AdressRepo->recupinfo($idform,$userid);
                    return new JsonResponse($adress_ajax);
                }
            $newAdress = new Adress;
            $user_verif = $this->getUser();
            $formAdress = $this->createForm(AdressFormType::class,$newAdress); 
            $formAdress->handleRequest($request);

                if ($formAdress->isSubmitted() && $formAdress->isValid()) {

                    $user_found = $formAdress->get('users')->getData();

                    if ($user_found->getId() === $userid) {
                        /** @var Adress $Adress */

                        // dd($formAdress->getData());
                        $entityManager->flush();
                        $this->addFlash('success', 'Votre Adresse a été mis à jour');
                        return $this->redirectToRoute('app_profile');
                    }
                }

            $user_verif = $this->getUser();
            $formAdress->get("users")->setData($user_verif);

            return $this->render('page/profile.html.twig', [
                'controller_name' => 'HomeController',
                'formUser' => $formUser->createView(),
                'formAdress' => $formAdress->createView(),
                'adress_user_selected' => $adress_user_selected,
            ]);}
        
    }
}

