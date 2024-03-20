<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FragementController extends AbstractController
{
    private $CategoryRepo;

    public function __construct(CategoryRepository $CategoryRepo)
    {   
        $this->CategoryRepo = $CategoryRepo;

    }

    //#[Route('/_navbar', name: 'app_navbar')]
    public function navbar(AuthenticationUtils $authenticationUtils): Response
    {
        $user = new Users();
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
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
        $user = new Users();
        $lastUsername = $authenticationUtils->getLastUsername();
        $error = $authenticationUtils->getLastAuthenticationError();
        $form_register = $this->createForm(RegistrationFormType::class, $user);
        $form_register->handleRequest($request);

        $category = $this->CategoryRepo->findAll();

        return $this->render('frag/_modal.html.twig', [
            'controller_name' => 'HomeController',
            'navbar_category' => $category,
            'registrationForm' => $form_register,
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }
}
