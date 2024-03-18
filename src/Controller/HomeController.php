<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{

    private $CategoryRepo;

    public function __construct(CategoryRepository $CategoryRepo)
    {   
        $this->CategoryRepo = $CategoryRepo;

    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        $category = $this->CategoryRepo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'navbar_category' => $category
        ]);
    }
}
