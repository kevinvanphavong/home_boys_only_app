<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\PictureProfile;
use App\Security\EmailVerifier;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class AdminUserController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }
    
    /**
     * @Route("/admin/my-profile", name="admin_profile_user")
     */
    public function index(): Response
    {
        return $this->render('admin_user/profile-user.html.twig', [
            'controller_name' => 'AdminUserController',
        ]);
    }

    /**
     * @Route("/admin/new-user", name="admin_new_user")
     * @param Request $request
     * @return Response
     */
    public function newUser(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user =  new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            // traitement de la photo de profil
            // $images = $userForm->get('pictureProfile')->getData();
            // foreach ($images as $image) {
            //     $imageName = md5(uniqid()) . '.' . $image->guessExtension();
            //     $image->move($this->getParameter('picture_profile'), $imageName);
            //     $newImage = new PictureProfile();
            //     $newImage->setName($imageName);
            //     // créer le lien entre les entités User et PictureProfile, dans l'entité User
            //     $user->setPictureProfile($newImage);
            // }


            // traitement du mot de passe
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $userForm->get('plainPassword')->getData()
                )
            );
            
            $user->setRoles(["ROLE_USER"]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            // $this->emailVerifier->sendEmailConfirmation(
            //     'app_verify_email',
            //     $user,
            //     (new TemplatedEmail())
            //     ->from(new Address('kevin45van@hotmail.fr', 'Mail registrations confirmations'))
            //     ->to($user->getEmail())
            //     ->subject('Please Confirm your Email')
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            // );
            // do anything else you need here, like send an email


            return $this->redirectToRoute('homepage');
        }

        return $this->render('admin_user/new-user.html.twig', [
            'userForm'  =>  $userForm->createView(),
            'user'  =>  $user,
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     */
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre putain d\'adresse email a bien été vérifié');

        // return $this->redirectToRoute('app_register');
        return $this->redirectToRoute('homepage');
    }
}
