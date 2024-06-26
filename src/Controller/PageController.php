<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\Orders;
use App\Entity\Panier;
use DateTimeImmutable;
use App\Entity\Delivery;
use App\Form\AdressFormType;
use App\Entity\ProductOrders;
use App\Entity\ProductDelivery;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
use App\Repository\OrdersRepository;
use App\Repository\PanierRepository;
use App\Repository\ProductRepository;
use App\Repository\DeliveryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Types\DateImmutableType;
use App\Repository\ProductOrdersRepository;
use Symfony\Component\Validator\Validation;
use App\Repository\ProductDeliveryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PageController extends AbstractController
{

    private $userRepo;
    private $AdressRepo;
    private $DeliveryRepo;
    private $OrdersRepo;
    private $ProductOrders;
    private $ProductDelivery;
    private $ProductRepo;
    private $panierRepo;

    public function __construct(PanierRepository $panierRepo,ProductRepository $ProductRepo,ProductDeliveryRepository $ProductDelivery,ProductOrdersRepository $ProductOrders, UsersRepository $userRepo,AdressRepository $AdressRepo,OrdersRepository $OrdersRepo,DeliveryRepository $DeliveryRepo){
        $this->userRepo = $userRepo;
        $this->AdressRepo = $AdressRepo;
        $this->ProductRepo= $ProductRepo;
        $this->OrdersRepo = $OrdersRepo;
        $this->ProductOrders = $ProductOrders;
        $this->ProductDelivery = $ProductDelivery;
        $this->DeliveryRepo = $DeliveryRepo;
        $this->panierRepo = $panierRepo;
    }
// Index
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('page/accueil.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
// PageCatalogue a genere
    #[Route('/catalogue/{categorie}', name: 'app_cat')]
    public function categorie($categorie): Response
    {
        
        return $this->render('page/catalogue/catalogue.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

// Fin Catalogue

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
// Gestion Commande | Panier
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

            return new JsonResponse($info_paiement);
        }
    }

    #[Route("/api_new/user_coef", name: 'user_coef')]
    public function user_coef(Request $request): Response
    {

        $user = $this->getUser();
        $coef = $user->getUserCoefficient();

        return new JsonResponse($coef);

    }

    #[Route('/bask/add', name: 'bask_add')]
    public function bask_add(Request $request,EntityManagerInterface $manager): Response
    {
        $id_produit_react = json_decode($request->getContent(), true);

        if ($id_produit_react === null) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }
        $id_produit = $id_produit_react['id_produit'] ?? null;
        $user = $this->getUser();
        $produit_setBDD = $this->ProductRepo->find(array('id' => $id_produit));
        $check_exist = $user->getPaniers();

        $panierExiste = false;
        foreach ($check_exist as $panier) {
            if ($panier->getProducts() === $produit_setBDD) {
                $panierExiste = $panier;
                break;
            }
        }
        
        if ($panierExiste != false) {
            $old_quantity = $panierExiste ->getQuantityProduit();
            $panierExiste->setQuantityProduit($old_quantity +1);

            $manager->flush();

        }
        else {
            $prix_client_ht_u = $produit_setBDD->getProPriceHT() * $user->getUserCoefficient();

            $panier = new Panier();
                $panier->setProducts($produit_setBDD);
                $panier->setQuantityProduit(1);
                $panier->setPriceUser($prix_client_ht_u);
                $panier->setUsers($user);
            $manager->persist($panier);
            $manager->flush();
    
        }

        $id_panier = $panier->getId();
        $panier_serveur = $user->getPaniers();

        foreach ($panier_serveur as $paniers) {
            $quantityProduit = $paniers->getQuantityProduit();
            $priceUser = $paniers->getPriceUser();
            
            $resultats[] = $quantityProduit * $priceUser;
        }

        $return_price = $panier->getPriceUser();
        $return_quantity = $panier->getQuantityProduit();

        if(isset($resultats) != true) {
            $resultats[] = 0; 
        }

        $prix_total = array_sum($resultats);

        $reponse_panier = [
            'price_user' => $return_price,
            'quantity' => $return_quantity,
            'id_del' => $id_panier,
            'prix_total' => $prix_total
        ];

        return new JsonResponse($reponse_panier);

    }

    #[Route('/aff_tab', name: 'aff_tab')]
    public function aff_tab(Request $request,EntityManagerInterface $manager): Response
    {
    
    if($request->isXmlHttpRequest()) {
    
    // Good
    
    $tableau = $request->request->all('info_livraison');
    $adress_facturation = $request->request->get('adress_facturation');
    $adress_livraison = $request->request->get('adress_livraison');
    for($yu = 0;$yu < count($tableau);$yu++){
        $date_convert = $tableau[$yu]['date'];
        $tableau[$yu]['date'] = new DateTimeImmutable($date_convert);
    }
        
    //Adress de fact non def definir fact = a livr
    if($adress_facturation === null){
        $adress_facturation = $adress_livraison;
    }
    // recuperation de l'adress entiere dans la bdd
    $id_to_string_adress_facturation = $this->AdressRepo->find(array('id' => $adress_facturation));
    $id_to_string_adress_livraison = $this->AdressRepo->find(array('id' => $adress_livraison));
    //id adress -> String
    //Adress facturation
    $num_adress_facturation = $id_to_string_adress_facturation->getAdrNumber();
    $rue_adress_facturation = $id_to_string_adress_facturation->getAdrStreet();
    $zip_adress_facturation = $id_to_string_adress_facturation->getAdrZipCode();
    $city_adress_facturation = $id_to_string_adress_facturation->getAdrCity();
    $addinfo_adress_facturation = $id_to_string_adress_facturation->getAdrAddInfo();
    $string_adress_facturation = "$num_adress_facturation $rue_adress_facturation $zip_adress_facturation $city_adress_facturation $addinfo_adress_facturation";
    
    //Adress livraison
    $num_adress_livraison = $id_to_string_adress_livraison->getAdrNumber();
    $rue_adress_livraison = $id_to_string_adress_livraison->getAdrStreet();
    $zip_adress_livraison = $id_to_string_adress_livraison->getAdrZipCode();
    $city_adress_livraison = $id_to_string_adress_livraison->getAdrCity();
    $addinfo_adress_livraison = $id_to_string_adress_livraison->getAdrAddInfo();
    $string_adress_livraison = "$num_adress_livraison $rue_adress_livraison $zip_adress_livraison $city_adress_livraison $addinfo_adress_livraison";

    // Recuperation panier
    $user = $this->getUser();
    $panier = $user->getPaniers();
    $produit_in_panier = [];

    //gestion date
    $date_day = new \DateTime();
    $date_estime = new \DateTime();
    $date_estime->add(new \DateInterval('P15D'));

    // Recuperation des id selectionne pour la livraison en plusieur fois
    $id_panier_a_supprimer = [];
    $table_lengt = count($tableau);
    for ($y = 0; $y < $table_lengt; $y++) {
        $id_exist = $tableau[$y]['id_panier'];
        array_push($id_panier_a_supprimer, $id_exist);
    }
    
    $article_in_panier = count($panier);

    // Suppression du panier des element livre en plusieur fois
    for ($x = 0; $x < $article_in_panier; $x++) {
        $id_panier = $panier[$x]->getId();
         if (in_array($id_panier ,  $id_panier_a_supprimer)) {
             unset($panier[$x]);
         }
     }

     for ($z = 0; $z <= count($panier); $z++) {
        if($panier[$z]){
         $insert = array(
             'qte' => 0,
             'date' => "0",
             'id_panier' => "0",
             'id_produit' => 0
         );

         $insert['qte'] = $panier[$z]->getQuantityProduit();
         $insert['date'] = $date_day;
         $insert['id_panier'] = $panier[$z]->getId();
         $product = $panier[$z]->getProducts();
         $insert['id_produit'] = $product->getId();

         $tableau[] = $insert;
        }
         // Ajouter l'objet Panier au tableau
     }
    //$tableau = panier a insert

        // Create Command
        $Order_user =  $this->getUser()->getOrders();
        // $order_ref_set = end($Order_user->getOrdRef()) + 1 ;
        if($Order_user[0]){
            $nbr_cmd_find = count($Order_user);
            $nbr_cmd_find--;
            $end_cmd = $Order_user[$nbr_cmd_find]->getOrdRef();
            $order_ref_set = $end_cmd;
        }
        else{
            $id_user = $user->getId();
            $order_ref_set = $id_user . 00 . 1;
        }

        $tva = 1.20;
        $reduction = 0;
        $order = new Orders();
                            
            $order->setOrdRef($order_ref_set);
            $order->setOrdClientCoefficient($user->getUserCoefficient());
            $order->setOrdAdressDelivery($string_adress_livraison);
            $order->setOrdAdressBilling($string_adress_facturation);
            $order->setOrdRebBill("Fact" . $order_ref_set);;
            $order->setOrdDateBill($date_day);
            // 1 = statut payé
            $order->setOrdStatusBill(1);
            // set user tva and reduct
            $order->setUsers($user);
            $order->setTvaCmd($tva);
            $order->setOrdReduction($reduction);

            // table calcul
            $a =  [];
            $b = [];

            //fusionne les tableau en leur donne les meme donne Qte | Date | Id Produit

            for ($x = 0; $x < count($tableau); $x++)
            {
                $quantity_produit = $tableau[$x]['qte'];
                $id_produit = $tableau[$x]['id_produit'];
                $set_livraison_client = $tableau[$x]['date'];
                // recup produit info
                $produit_setBDD= $this->ProductRepo->find(array('id' => $id_produit));
                // set new delivery
                $delivery[$x] = new Delivery();
                $delivery[$x]->setDelDateExped($date_day);
                $delivery[$x]->setDelDatePlannedDelivery($set_livraison_client);
                $delivery[$x]->setOrders($order);
                            
                //re calcul prix (ht)
                $prix_client_ht_u = $produit_setBDD->getProPriceHT() * $user->getUserCoefficient();
                
                $productorder[$x] = new ProductOrders();
            
                    $productorder[$x]->setProOrdProductQuantity($quantity_produit);
                    $productorder[$x]->setProOrdNameProduct($produit_setBDD->getProName()); 
                    $productorder[$x]->setProOrdPriceUht($prix_client_ht_u); 
                    $productorder[$x]->setProduct($produit_setBDD);
                    $productorder[$x]->setOrders($order);
                    
                $productdelivery[$x] = new ProductDelivery();
            
                    $productdelivery[$x]->setProDelProductQuantity($quantity_produit); 
                    $productdelivery[$x]->setProduct($produit_setBDD);
                    $productdelivery[$x]->setDelivery($delivery[$x]);
                    // calcul prix ht ttc
                    $setPriceLigneht = $prix_client_ht_u * $quantity_produit + $reduction;
                    $setPriceLignettc = $prix_client_ht_u * $quantity_produit * $tva + $reduction;
                    $productorder[$x]->setPriceLigne($setPriceLignettc);
                    $productorder[$x]->setPriceLigneht($setPriceLigneht);

                $manager->persist($delivery[$x]);
                $manager->persist($productorder[$x]);
                $manager->persist($productdelivery[$x]);

                $a[] = $setPriceLigneht;
                $b[] = $setPriceLignettc;
            }
            
            $prix_cmd_ht = array_sum($a);
            $prix_cmd_ttc = array_sum($b);

            $order->setOrdPrixTotal($prix_cmd_ttc);
            $order->setOrdPrixTotalHT($prix_cmd_ht);
            
            $manager->persist($order);
            $user = $this->getUser();
            $this->panierRepo->removeAllCartsForUser($user);
            $manager->flush();

            return new JsonResponse(True);
        }

    }
}

