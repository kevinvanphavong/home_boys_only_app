<?php

namespace App\Controller;

use App\Entity\PictureProfile;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/profile-user", name="admin_profile_user")
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
    public function newUser(Request $request): Response
    {
        $user =  new User();
        $userForm = $this->createForm(UserType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $images = $userForm->get('pictureProfile')->getData();

            // foreach ($images as $image) {
            //     $imageName = md5(uniqid()) . '.' . $image->guessExtension();
            //     $image->move($this->getParameter('picture_profile'), $imageName);
            //     $newImage = new PictureProfile();
            //     $newImage->setName($imageName);
            //     // créer le lien entre les entités User et PictureProfile, dans l'entité User
            //     $user->setPictureProfile($newImage);
            // }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin_profile_user');
        }

        return $this->render('admin_user/new-user.html.twig', [
            'userForm'  =>  $userForm->createView(),
            'user'  =>  $user,
        ]);
    }
}
