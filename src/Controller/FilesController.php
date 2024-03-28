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
use Pontedilana\PhpWeasyPrint\Pdf;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Twig\Environment;
use Pontedilana\WeasyprintBundle\WeasyPrint\Response\PdfResponse;

class FilesController extends AbstractController
{
    private $userRepo;
    private $AdressRepo;
    private $DeliveryRepo;
    private $OrdersRepo;
    private $ProductOrders;
    private $ProductDelivery;
    private $twig;
    public $pdf;

    public function __construct(Pdf $pdf,Environment $twig,ProductDeliveryRepository $ProductDelivery,ProductOrdersRepository $ProductOrders, UsersRepository $userRepo,AdressRepository $AdressRepo,OrdersRepository $OrdersRepo,DeliveryRepository $DeliveryRepo){
        $this->userRepo = $userRepo;
        $this->AdressRepo = $AdressRepo;
        $this->OrdersRepo = $OrdersRepo;
        $this->ProductOrders = $ProductOrders;
        $this->ProductDelivery = $ProductDelivery;
        $this->DeliveryRepo = $DeliveryRepo;
        $this->twig = $twig;
        $this->pdf = $pdf;
    }


    #[Route('/facture/{id}', name: 'app_facture')]
    public function facture($id,Request $request): Response
    {
        $user_cmd_orders = $this->OrdersRepo->findBy(array('id' => $id));
        $user_cmd_delivery = $this->DeliveryRepo->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductOrders = $this->ProductOrders->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductDelivery = $this->ProductDelivery->findBy(array('delivery' => $user_cmd_delivery));
        $id_user_find = $user_cmd_orders[0]->getUsers();
        $user = $this->userRepo->findBy(array('id' => $id_user_find));

        $ref_cmd = $user_cmd_orders[0]->getOrdRef();
        $cmd_name = 'facture'.$ref_cmd.'.pdf';

        $html = $this->renderView(
            'files/facture.html.twig',
            [
                'histo_cmd' => $user_cmd_orders,
                'histo_delivery' => $user_cmd_delivery,
                'product_orders' => $user_cmd_ProductOrders,
                'product_delivery' => $user_cmd_ProductDelivery,
                'user' => $user
            ]
        );

        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            $cmd_name
        );
    }
    #[Route('/bonlivraison/{id}', name: 'app_bonlivraison')]
    public function bonlivraison($id,Request $request): Response
    {
        $user_cmd_orders = $this->OrdersRepo->findBy(array('id' => $id));
        $user_cmd_delivery = $this->DeliveryRepo->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductOrders = $this->ProductOrders->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductDelivery = $this->ProductDelivery->findBy(array('delivery' => $user_cmd_delivery));
        $id_user_find = $user_cmd_orders[0]->getUsers();
        $user = $this->userRepo->findBy(array('id' => $id_user_find));

        $ref_cmd = $user_cmd_orders[0]->getOrdRef();
        $cmd_name = 'Bon_Livraison'.$ref_cmd.'.pdf';

        $html = $this->renderView(
            'files/bonlivraison.html.twig',
            [
                'histo_cmd' => $user_cmd_orders,
                'histo_delivery' => $user_cmd_delivery,
                'product_orders' => $user_cmd_ProductOrders,
                'product_delivery' => $user_cmd_ProductDelivery,
                'user' => $user
            ]
        );

        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            $cmd_name
        );
    }
    #[Route('/boncmd/{id}', name: 'app_boncmd')]
    public function boncmd($id,Request $request): Response
    {

        $user_cmd_orders = $this->OrdersRepo->findBy(array('id' => $id));
        $user_cmd_delivery = $this->DeliveryRepo->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductOrders = $this->ProductOrders->findBy(array('orders' => $user_cmd_orders));
        $user_cmd_ProductDelivery = $this->ProductDelivery->findBy(array('delivery' => $user_cmd_delivery));
        $id_user_find = $user_cmd_orders[0]->getUsers();
        $user = $this->userRepo->findBy(array('id' => $id_user_find));

        $ref_cmd = $user_cmd_orders[0]->getOrdRef();
        $cmd_name = 'Bon_Commande'.$ref_cmd.'.pdf';

        $html = $this->renderView(
            'files/boncmd.html.twig',
            [
                'histo_cmd' => $user_cmd_orders,
                'histo_delivery' => $user_cmd_delivery,
                'product_orders' => $user_cmd_ProductOrders,
                'product_delivery' => $user_cmd_ProductDelivery,
                'user' => $user
            ]
        );

        return new PdfResponse(
            $this->pdf->getOutputFromHtml($html),
            $cmd_name
        );
    }
}
