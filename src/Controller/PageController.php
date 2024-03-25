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
            //Historique cmd 
            $user_cmd_orders = $this->OrdersRepo->findBy(array('users' => $userid));
            $user_cmd_delivery = $this->DeliveryRepo->findBy(array('orders' => $user_cmd_orders));
            $user_cmd_ProductOrders = $this->ProductOrders->findBy(array('orders' => $user_cmd_orders));
            $user_cmd_ProductDelivery = $this->ProductDelivery->findBy(array('delivery' => $user_cmd_delivery));

            return $this->render('page/profile.html.twig', [
                'controller_name' => 'HomeController',
                'formUser' => $formUser->createView(),
                'formAdress' => $formAdress->createView(),
                'adress_user_selected' => $adress_user_selected,
                'histo_cmd' => $user_cmd_orders,
                'histo_delivery' => $user_cmd_delivery,
                'product_orders' => $user_cmd_ProductOrders,
                'product_delivery' => $user_cmd_ProductDelivery,
                'user' => $user_co
            ]);}
        
    }

   
}

