<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductDeliveryRepository;
use App\Repository\ProductOrdersRepository;
use App\Repository\DeliveryRepository;
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
    private $DeliveryRepo;
    private $OrdersRepo;
    private $ProductOrders;
    private $ProductDelivery;

    public function __construct(ProductDeliveryRepository $ProductDelivery,ProductOrdersRepository $ProductOrders, UsersRepository $userRepo,AdressRepository $AdressRepo,OrdersRepository $OrdersRepo,DeliveryRepository $DeliveryRepo){
        $this->userRepo = $userRepo;
        $this->AdressRepo = $AdressRepo;
        $this->OrdersRepo = $OrdersRepo;
        $this->ProductOrders = $ProductOrders;
        $this->ProductDelivery = $ProductDelivery;
        $this->DeliveryRepo = $DeliveryRepo;
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
        // recup id user
        $userid = $this->getUser()->getId();
        if ($userid)
        {
            $user_co = $this->getUser();
            // Create Form Modif Profil
            $formUser = $this->createForm(RegistrationFormType::class, $this->getUser());
            $formUser->handleRequest($request);
            // Create Form Add/Modif Adress
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
                'user' => $user_co
            ]);}
        
    }

    #[Route('/commande', name: 'app_commande')]
    public function commande(Request $request): Response
    {
        $user = $this->getUser();
        $panier = $user->getPaniers();


        if(isset($resultats) != true) {
            $resultats[] = 0; 
           }
        foreach ($panier as $paniers) {
         $quantityProduit = $paniers->getQuantityProduit();
         $priceUser = $paniers->getPriceUser();
         
         $resultats[] = $quantityProduit * $priceUser;
        }
        
        $prix_total = array_sum($resultats);

         $newAdress = new Adress;
         $formAdress = $this->createForm(AdressFormType::class,$newAdress);
         $formAdress->handleRequest($request);
         $formAdress->get("users")->setData($user);


            return $this->render('page/confirmation_panier.html.twig', [
                'panier'=> $panier,
                'prix_total' => $prix_total,
                'formAdress' => $formAdress->createView()
            ]);
        
    }

    #[Route('/paiement', name: 'app_paiement')]
    public function paiement(Request $request): Response
    {
        $user = $this->getUser();
        $panier = $user->getPaniers();

        foreach ($panier as $paniers) {
            $quantityProduit = $paniers->getQuantityProduit();
            $priceUser = $paniers->getPriceUser();
            
            $resultats[] = $quantityProduit * $priceUser;
           }
           
           $prix = array_sum($resultats);

            return $this->render('page/paiement.html.twig', [
                'prix' => $prix
            ]);
        
    }

   
}
