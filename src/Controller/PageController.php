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
use App\Security\AppCustomAuthenticator;



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
    public function profile(AuthenticationUtils $authenticationUtils,Request $request,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager): Response
    {

        $userid = $this->getUser()->getId();
        if($userid){
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $identifiant = $this->getUser()->getUserIdentifier();

        $formUser = $this->createForm(RegistrationFormType::class, $this->getUser());
        $formUser->handleRequest($request);
    
        if ($formUser->isSubmitted() && $formUser->isValid()) {
            /** @var User $user */
            $user = $formUser->getData();
            $plainPassword = $formUser->get('Password')->getData();
            
            // if (null !== $plainPassword) {
            //     $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            // }
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour');
    
        }

        $recup_adress = $this->AdressRepo->AdressUser($userid);
        $assembly_adress = $this->AdressRepo->AssemblyAdress($recup_adress);

        $task = $this->AdressRepo->getId(1);
        $formAdress = $this->createForm(AdressFormType::class,$task);
        $formAdress->handleRequest($request);




        return $this->render('page/profile.html.twig', [
            'controller_name' => 'HomeController',
            'formUser' => $formUser->createView(),
            'adress_select' => $assembly_adress,
            'adress_detail' => $recup_adress,
            'formAdress' => $formAdress->createView(),
        ]);
        
    }
}
}
