<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class HomeController extends AbstractController
{

    private $CategoryRepo;
    private EmailVerifier $emailVerifier;

    public function __construct(CategoryRepository $CategoryRepo,EmailVerifier $emailVerifier)
    {   
        $this->CategoryRepo = $CategoryRepo;
        $this->emailVerifier = $emailVerifier;

    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new Users();
        $form_register = $this->createForm(RegistrationFormType::class, $user);
        $form_register->handleRequest($request);

        if ($form_register->isSubmitted() && $form_register->isValid()) {
            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                    $user,
                    $form_register->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('contact@greenvillage.fr', 'Green Village'))
                    ->to($user->getUserEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }
        $category = $this->CategoryRepo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'navbar_category' => $category,
            'registrationForm' => $form_register,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UsersRepository $usersRepository): Response
    {
        $id = $request->query->get('id');
        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $usersRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }
       try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }
       $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
