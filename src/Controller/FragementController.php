<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Panier;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Repository\ProductRepository;
use App\Repository\PanierRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class FragementController extends AbstractController
{
    private $CategoryRepo;
    private $userRepo;
    private $PanierRepository;
    private $entityManager;
    private $ProductRepo;

    public function __construct(ProductRepository $ProductRepo,EntityManagerInterface $entityManager,CategoryRepository $CategoryRepo,UsersRepository $userRepo,PanierRepository $PanierRepository)
    {   
        $this->userRepo = $userRepo;
        $this->CategoryRepo = $CategoryRepo;
        $this->PanierRepository = $PanierRepository;
        $this->entityManager = $entityManager;
        $this->ProductRepo = $ProductRepo;

    }

    //#[Route('/_navbar', name: 'app_navbar')]
    public function navbar(AuthenticationUtils $authenticationUtils,Request $request): Response
    {
        // Create Form
        $user = new Users();
        // $user_identif = $this->getUsers;
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        // Find Category
        $category = $this->CategoryRepo->findAll();

        return $this->render('frag/_navbar.html.twig', [
            'controller_name' => 'HomeController',
            'navbar_category' => $category,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    public function modal(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,AuthenticationUtils $authenticationUtils): Response
    {
        // Create Form
        $user = new Users();
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        $form_register = $this->createForm(RegistrationFormType::class, $user);
        $form_register->handleRequest($request);

        return $this->render('frag/_modal.html.twig', [
            'controller_name' => 'HomeController',
            'registrationForm' => $form_register,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }


    #[Route('/actu/panier', name: 'app_panier_actu')]
    public function panier(Request $request): Response
    {
        $user =  $this->getUser();
        $panier = $user->getPaniers();
        $product = $this->ProductRepo->findAll();

        foreach ($panier as $paniers) {
            $quantityProduit = $paniers->getQuantityProduit();
            $priceUser = $paniers->getPriceUser();
            
            $resultats[] = $quantityProduit * $priceUser;
        }
        if(isset($resultats)){
            $prix_total = array_sum($resultats);
        }
        else {$prix_total = 0;}

        if ($request->isXmlHttpRequest()) {
            
            $user =  $this->getUser();
            $panier = $user->getPaniers();
            $product = $this->ProductRepo->findAll();
    
            foreach ($panier as $paniers) {
                $quantityProduit = $paniers->getQuantityProduit();
                $priceUser = $paniers->getPriceUser();
                
                $resultats[] = $quantityProduit * $priceUser;
            }
            if(isset($resultats)){
                $prix_total = array_sum($resultats);
            }
            else {$prix_total = 0;}
            return $this->render('frag/_panier.html.twig', [
                'controller_name' => 'HomeController',
                'panier_client' => $user,
                'prix_total' => $prix_total,
                'product' => $product
            ]);
        }

        return $this->render('frag/_panier.html.twig', [
            'controller_name' => 'HomeController',
            'panier_client' => $user,
            'prix_total' => $prix_total,
            'product' => $product
        ]);
    }

    #[Route('/panier_quantity', name: 'panier_quantity')]
    public function panier_quantity(Request $request): Response
    {
        $user =  $this->getUser();
        $panier_serveur = $user->getPaniers();
        $id_check = [];
        $i = 0;

        foreach($panier_serveur as $key => $value) {
            array_push($id_check,$panier_serveur[$i]->getId());
            $i++;
        }

        if($request->isXmlHttpRequest()) {

            $id_panier = $request->request->get('value');
            $modif_quantity = $request->request->get('quantity');

            // $repo = $this->entityManager->getRepository(Panier::class);
            $panier = $this->PanierRepository->find($id_panier);

            if(in_array($panier->getId(),$id_check) === true){

                $old_quantity = $panier->getQuantityProduit();
                $price_unite = $panier->getPriceUser();


                //Quantity +1
                if($modif_quantity == "-"){
                    $new_quantity = $old_quantity - 1;

                    $panier->setQuantityProduit($new_quantity);

                    $this->entityManager->flush();
                }
                
                //Quantity -1
                if($modif_quantity == "+"){
                    $new_quantity = $old_quantity + 1;

                    $panier->setQuantityProduit($new_quantity);

                    $this->entityManager->flush();
                    
                }
                //Sup
                if($modif_quantity == "del"){
                            
                    $new_quantity = 0;

                }


                if($new_quantity == 0){
                    
                    $this->entityManager->remove($panier);
                    $this->entityManager->flush();
                }
        
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


            }
    }
}
