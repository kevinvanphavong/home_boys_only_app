<?php

namespace App\Controller;

use App\Entity\Partygoer;
use App\Entity\ProfileImage;
use App\Entity\ProfilePicture;
use App\Entity\User;
use App\Form\UserType;
use App\Form\PartygoerType;
use App\Security\EmailVerifier;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     *
     * @Route("/my-account/personnal-informations", name="admin_user_profile")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $partygoer = $this->getUser()->getPartygoer();
        $partygoerForm = $this->createForm(PartygoerType::class, $partygoer);
        $partygoerForm->handleRequest($request);
        
        if ($partygoerForm->isSubmitted() && $partygoerForm->isValid()) {  
            
            // si il y a un changement de photo de profile
            if ($partygoerForm->get('profilePicture')->getData() !== null && $partygoer->getProfileImage() !== null){
                $this->modifyProfilePicture($partygoer, $partygoer->getProfileImage(), $partygoerForm->get('profilePicture')->getData());
            // si c'est l'ajout d'une photo de profile pour la 1ere fois
            } elseif ($partygoerForm->get('profilePicture')->getData() !== null){
                $this->modifyProfilePicture($partygoer, $partygoerForm->get('profilePicture')->getData());
            }

            // handling new user email if edit
            $user = $this->getUser();
            $user->setEmail($partygoerForm->get('email')->getData());

            $partygoer->getLifeInterests();
            
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vos informations ont bien été enregistrés ;)');
        }

        return $this->render('admin_user/user-profile.html.twig', [
            'partygoerForm' => $partygoerForm->createView(),
            'partygoer' => $partygoer,
        ]);
    }

    /**
     * @Route("/user/registration", name="user_registration")
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
            // $user->setPassword(
            //     $userPasswordHasherInterface->hashPassword(
            //         $user,
            //         $userForm->get('plainPassword')->getData()
            //     )
            // );
            
            // $user->setRoles(["ROLE_USER"]);

            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($user);
            // $entityManager->flush();

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

        return $this->render('admin_user/user-registration.html.twig', [
            'userForm'  =>  $userForm->createView(),
            'user'  =>  $user,
        ]);
    }

    /**
     * @Route("/verify/email", name="app_verify_email")
     * @param Request $request
     * @return Response
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

    /**
     *
     * @param Partygoer $partygoer
     * @param [type] $oldProfilePicture
     * @param [type] $newProfilePicture
     * @return void
     */
    public function modifyProfilePicture(Partygoer $partygoer, $oldProfilePicture, $newProfilePicture = null)
    {
        if($newProfilePicture !== null) {

            // 1) on supprime l'ancienne PP en image sur le dossier /public
            unlink($this->getParameter('profile_pictures') . '/partygoer_id_' . $partygoer->getId() . '/' .$oldProfilePicture->getName());
            // 2) on fait le même process pour la nouvelle photo de profile
            $profilePictureName = md5(uniqid()) . '.' . $newProfilePicture->guessExtension();
            $newProfilePicture->move($this->getParameter('profile_pictures') . '/partygoer_id_' . $partygoer->getId(), $profilePictureName);

            $partygoer->getProfileImage()->setName($profilePictureName);
        } else {
            $profilePictureName = md5(uniqid()) . '.' . $oldProfilePicture->guessExtension();
            $oldProfilePicture->move($this->getParameter('profile_pictures') . '/partygoer_id_' . $partygoer->getId(), $profilePictureName);
            $image = new ProfileImage();
            $image->setName($profilePictureName);
            $image->setPartygoer($partygoer);
            $partygoer->setProfileImage($image);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    }

    /**
     * @Route("/my-account/personnal-informations/modify/personal-interests/{partygoerId}", name="admin_user_profile_modify_personal_interests")
     * @ParamConverter("partygoer", options={"id" = "partygoerId"})
     */
    public function validatePersonalInterests(Request $request, Partygoer $partygoer): Response
    {
        try {
            $data = json_decode($request->getContent());

            $partygoer->setFoodTastes(ucfirst(strtolower(implode(',', $data->foodTastes))));
            $partygoer->setMusicTastes(ucfirst(strtolower(implode(',', $data->musicTastes))));
            $partygoer->setLifeInterests(ucfirst(strtolower(implode(',', $data->lifeInterests))));

            $this->getDoctrine()->getManager()->persist($partygoer);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Vos centres d\'intérêts ont bien été enregistrés ;)');

            return new JsonResponse('Good', 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
