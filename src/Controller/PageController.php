<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
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
            // Create Form
            $formUser = $this->createForm(RegistrationFormType::class, $this->getUser());
            $formUser->handleRequest($request);
            $newAdress = new Adress;
            $formAdress = $this->createForm(AdressFormType::class,$newAdress); 
            $formAdress->handleRequest($request);
            // Set Variable
            $adress_user_selected = $this->AdressRepo->findBy(array('users' => $userid));
            $user_verif = $this->getUser();
            $formAdress->get("users")->setData($user_verif);
                //Ajax request
                if($request->isXmlHttpRequest()) {

                    $userid = $this->getUser()->getId();
                    $idform = $request->request->get('setform');
                    $adress_ajax = $this->AdressRepo->recupinfo($idform,$userid);
                    return new JsonResponse($adress_ajax);
                }

            return $this->render('page/profile.html.twig', [
                'controller_name' => 'HomeController',
                'formUser' => $formUser->createView(),
                'formAdress' => $formAdress->createView(),
                'adress_user_selected' => $adress_user_selected,
            ]);}
        
    }

   
}

