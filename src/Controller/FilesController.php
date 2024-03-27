<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UsersRepository;
use App\Repository\AdressRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductDeliveryRepository;
use App\Repository\ProductOrdersRepository;
use App\Repository\DeliveryRepository;

class FilesController extends AbstractController
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

    #[Route('/facture/{id}', name: 'app_facture')]
    public function index($id,Request $request): Response
    {

        $user_cmd_orders = $this->OrdersRepo->findBy(array('id' => $id));
        $user_cmd_delivery = $this->DeliveryRepo->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductOrders = $this->ProductOrders->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductDelivery = $this->ProductDelivery->findBy(array('delivery' => $user_cmd_delivery));
        $id_user_find = $user_cmd_orders[0]->getUsers();
        $user = $this->userRepo->findBy(array('id' => $id_user_find));

        dump($user);

        return $this->render('files/facture.html.twig', [
            'controller_name' => 'FilesController',
            'histo_cmd' => $user_cmd_orders,
            'histo_delivery' => $user_cmd_delivery,
            'product_orders' => $user_cmd_ProductOrders,
            'product_delivery' => $user_cmd_ProductDelivery,
            'user' => $user
        ]);
    }
}
