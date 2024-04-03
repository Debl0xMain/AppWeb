<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrdersRepository;
use App\Repository\DeliveryRepository;
use App\Repository\ProductOrdersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    private $OrdersRepo;
    private $deliveryRepo;
    private $pro_ordRepo;

    public function __construct(OrdersRepository $OrdersRepo, DeliveryRepository $deliveryRepo,ProductOrdersRepository $pro_ordRepo){

        $this->OrdersRepo = $OrdersRepo;
        $this->deliveryRepo = $deliveryRepo;
        $this->pro_ordRepo = $pro_ordRepo;

    }
   
    #[Route('/stats', name: 'app_config')]
    public function stats(Request $request,OrdersRepository $OrdersRepo): Response
    {
        $year = 0000;
        $year_top = 2024;
        $m = [1,2,3,4,5,6,7,8,9,10,11,12];

        for($i = 0;$i<=11;$i++){

            $date_d_year_reponse_client = $year . '-'. $m[$i] . '-01';
            $date_f_year_reponse_client = $year . '-'. $m[$i] . '-31';
            $date_d_year = new \DateTime($date_d_year_reponse_client);
            $date_f_year = new \DateTime($date_f_year_reponse_client);
            $x = $i + 1;
            $reponse = $OrdersRepo->find_id($date_d_year,$date_f_year);

            $ca[$x] = $reponse;
        }

        // Type Client
        
        $year_typecli = 2024; 

        $date_d_year_reponse_client_typecli = $year_typecli . '-01-01';
        $date_f_year_reponse_client_typecli  = $year_typecli . '-12-31';

        $date_d_year_cli = new \DateTime($date_d_year_reponse_client_typecli);
        $date_f_year_cli = new \DateTime($date_f_year_reponse_client_typecli);

        $cli_pro = $OrdersRepo->ca_client_pro($date_d_year_cli,$date_f_year_cli);

        $cli_par = $OrdersRepo->ca_client_par($date_d_year_cli,$date_f_year_cli);

        $delivery_number = $this->deliveryRepo->delivery_number();


        $top10_quantity = $this->pro_ordRepo->top10_quantity($year_top);
        $top10_price = $this->pro_ordRepo->top10_price($year_top);

        return $this->render('admin/stats.html.twig', [
            'controller_name' => 'AdminController',
            'ca' => $ca,
            'type_client_par' => $cli_par[0][1],
            'type_client_pro' => $cli_pro[0][1],
            'delivery_number' => $delivery_number,
            'top10_price' => $top10_price,
            "top10_quantity" => $top10_quantity
        ]);
    }

                                                    // // // Ajax \\ \\ \\

// Stats chiffre d'affaire entreprise année / mois
    #[Route('/ajax_stats_year', name: 'app_ajax_stats_year')]
    public function ajax_stats_year(Request $request,OrdersRepository $OrdersRepo): Response
    {
        $m = [1,2,3,4,5,6,7,8,9,10,11,12];

        if($request->isXmlHttpRequest()) {

            // CA/Années
            $year = $request->request->get('set_year');
            for($i = 0;$i<=11;$i++){

                $date_d_year_reponse_client = $year . '-'. $m[$i] . '-01';
                $date_f_year_reponse_client = $year . '-'. $m[$i] . '-31';
        
                $date_d_year = new \DateTime($date_d_year_reponse_client);
                $date_f_year = new \DateTime($date_f_year_reponse_client);

                $x = $i + 1;

                $reponse = $OrdersRepo->find_id($date_d_year,$date_f_year);
    
                $ca[$x] = $reponse;
            }

            return new JsonResponse($ca);
        }
    }
// chiffre d'affaire client / annéee
    #[Route('/ajax_ca_year', name: 'app_ajax_ca_year')]
    public function ajax_ca_year(Request $request,OrdersRepository $OrdersRepo): Response
    {

        if($request->isXmlHttpRequest()) {

            $year_typecli = $request->request->get('select_year_ca_type');

            $date_d_year_reponse_client_typecli = $year_typecli . '-01-01';
            $date_f_year_reponse_client_typecli  = $year_typecli . '-12-31';
    
            $date_d_year_cli = new \DateTime($date_d_year_reponse_client_typecli);
            $date_f_year_cli = new \DateTime($date_f_year_reponse_client_typecli);
    
            $cli_pro = $OrdersRepo->ca_client_pro($date_d_year_cli,$date_f_year_cli);
    
            $cli_par = $OrdersRepo->ca_client_par($date_d_year_cli,$date_f_year_cli);

            $json_tab = [
                            "cli_pro" => $cli_pro,
                            "cli_par" => $cli_par
                        ];

            $ajax_reponse = json_encode($json_tab);
            

            return new JsonResponse($ajax_reponse);
        }
    }
    // top 10 produit
    #[Route('/ajax_year_top_produit', name: 'app_ajax_year_top_produit')]
    public function ajax_year_top_produit(Request $request): Response
    {

        if($request->isXmlHttpRequest()) {

            $year_top_produit_ajax = $request->request->get('select_year_top_produit');

            $top10_quantity = $this->pro_ordRepo->top10_quantity($year_top_produit_ajax);
            $top10_price = $this->pro_ordRepo->top10_price($year_top_produit_ajax);

            $table_json = [
                "top10_quantity" => $top10_quantity,
                "top10_price" => $top10_price
            ];

            $table = json_encode($table_json);
            

            return new JsonResponse($table);
        }
    }
}