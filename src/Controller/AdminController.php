<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\OrdersRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    private $OrdersRepo;

    public function __construct(OrdersRepository $OrdersRepo){

        $this->OrdersRepo = $OrdersRepo;

    }
   
    #[Route('/stats', name: 'app_config')]
    public function stats(Request $request,OrdersRepository $OrdersRepo): Response
    {
        $year = 2024;

        if($request->isXmlHttpRequest()) {

            // CA/Années
            $year = $request->request->get('set_year');
            $m = [1,2,3,4,5,6,7,8,9,10,11,12];

                for($i = 0;$i<=11;$i++){
                    $date_d_year_reponse_client = $year . '-'. $m[$i] . '-01';
                    $date_f_year_reponse_client = $year . '-'. $m[$i] . '-31';
                
                    $date_d_year = new \DateTime($date_d_year_reponse_client);
                    $date_f_year = new \DateTime($date_f_year_reponse_client);

                    $x = $i + 1;
                    $reponse = $OrdersRepo->find_id($date_d_year,$date_f_year);
                    $ca[$x] = [$i ,$reponse[0]];
                }

            return new JsonResponse($ca);
        }

        $m = [1,2,3,4,5,6,7,8,9,10,11,12];

        for($i = 0;$i<=11;$i++){
            $date_d_year_reponse_client = $year . '-'. $m[$i] . '-01';
            $date_f_year_reponse_client = $year . '-'. $m[$i] . '-31';
    
            $date_d_year = new \DateTime($date_d_year_reponse_client);
            $date_f_year = new \DateTime($date_f_year_reponse_client);
            $x = $i + 1;
            $reponse = $OrdersRepo->find_id($date_d_year,$date_f_year);
            $ca[$x] = [$i ,$reponse[0]];
        }

        return $this->render('admin/stats.html.twig', [
            'controller_name' => 'AdminController',
            'ca' => $ca,
        ]);
    }
}