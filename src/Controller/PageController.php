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

    #[Route('/sys_paie', name: 'sys_paie')]
    public function sys_paie(Request $request): Response
    {
        //Ajax request
        if($request->isXmlHttpRequest()) {
            $info_paiement = $request->request->get('paiement');
            // apel service insertion commande base de donne
            $user = $this->getUser();
            $panier = $user->getPaniers();

            
            // 
            return new JsonResponse($info_paiement);
        }
    }



    #[Route('/test', name: 'test')]
    public function test(Request $request): Response
    {
        // Paramettre
        $id_adress_livraison = $request->request->get('id_adress_livraison');
        $id_adress_facturation = $request->request->get('id_adress_facturation');
        if($id_adress_facturation === null){
            $id_adress_facturation = $id_adress_livraison;
        }

        //info livraison plusieur fois
        
        // Recup user et panier
        $user = $this->getUser();
        $panier = $user->getPaniers();
        $panier_produit = $panier;
        $produit = [];
        // Recherche des produits contenu dans le paniers
        foreach ($panier as $paniers) {
            $produit_panier = $paniers->getProducts();
            
            array_push($produit, $produit_panier);
           }

        
        $date_j = new \DateTime();
        $date_estime = new \DateTime();
        $date_estime->add(new \DateInterval('P15D'));
// $produit boucle count(produit)
        $tva = 1.20;
// recup adress utilise pour la livraison

$adress_get = $user->getAdresses();

$num_adress = $adress_get->getAdrNumber();
$rue_adress = $adress_get->getAdrStreet();
$zip_adress = $adress_get->getAdrZipCode();
$city_adress = $adress_get->getAdrCity();
$addinfo_adress = $adress_get->getAdrAddInfo();
// adresse de livraison
$adress_user_get = "$num_adress $rue_adress $zip_adress $city_adress $addinfo_adress ";




    }
}

