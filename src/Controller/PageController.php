<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Entity\Orders;
use App\Entity\Delivery;
use App\Form\AdressFormType;
use App\Entity\ProductOrders;
use App\Entity\ProductDelivery;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductRepository;
use App\Repository\DeliveryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProductOrdersRepository;
use App\Repository\ProductDeliveryRepository;
use DateTime;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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

    public function __construct(ProductRepository $ProductRepo,ProductDeliveryRepository $ProductDelivery,ProductOrdersRepository $ProductOrders, UsersRepository $userRepo,AdressRepository $AdressRepo,OrdersRepository $OrdersRepo,DeliveryRepository $DeliveryRepo){
        $this->userRepo = $userRepo;
        $this->AdressRepo = $AdressRepo;
        $this->ProductRepo= $ProductRepo;
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

            return new JsonResponse($info_paiement);
        }
    }

    #[Route('/aff_tab', name: 'aff_tab')]
    public function aff_tab(Request $request,EntityManagerInterface $manager): Response
    {
    
    if($request->isXmlHttpRequest()) {
    
    // Good
    
    $tableau = $request->request->all('info_livraison');
    $adress_facturation = $request->request->get('adress_facturation');
    $adress_livraison = $request->request->get('adress_livraison');

        
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
// $tableau;
// Gestion Boucle
            for ($x = 0; $x <= count($tableau); $x++)
            {
                // set id produit
                // if object exist set quantity object else qte max
                $quantity_produit = $tableau[$x]['qte'];
                // recup id produit ligne cmd
                $id_produit = Intval($tableau[$x]['id_produit']);
                //Date de livraison 
                $set_livraison_client = $tableau[$x]['date'];
                // recup produit info
                $produit_setBDD= $this->ProductRepo->find(array('id' => $id_produit));

                // set new delivery
                $delivery[$x] = new Delivery();
                
                $delivery[$x]->setDelDateExped($date_day);
                // If object.date dont exist or is null set date estime  
                $delivery[$x]->setDelDatePlannedDelivery(new DateTime($set_livraison_client));
                // else $delivery[$x]->setDelDatePlannedDelivery($object_date);
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
                    $setPriceLigneht = $prix_client_ht_u * $quantity_produit * $reduction;
                    $setPriceLignettc = $prix_client_ht_u * $quantity_produit * $tva * $reduction;
                    $productorder[$x]->setPriceLigne($setPriceLignettc);
                    $productorder[$x]->setPriceLigneht($setPriceLigneht);

                $manager->persist($delivery[$x]);
                $manager->persist($productorder[$x]);
                $manager->persist($productdelivery[$x]);

                $a = [$productorder[$x]->getPriceligne()];
                $b = [$productorder[$x]->getPriceligneht()];
            }
            
            $prix_cmd_ht = array_sum($b);
            $prix_cmd_ttc = array_sum($a);

            $order->setOrdPrixTotal($prix_cmd_ttc);
            $order->setOrdPrixTotalHT($prix_cmd_ht);
            
            $manager->persist($order);

            return new JsonResponse(True);
        }

    }
}

