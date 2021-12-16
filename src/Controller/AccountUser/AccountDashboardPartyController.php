<?php

namespace App\Controller\AccountUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("my-account", name="my_account")
 */
class AccountDashboardPartyController extends AbstractController
{
    /**
     * @Route("/dashboard-parties", name="_dashboard_parties")
     */
    public function getDashboardPartyPage(): Response
    {
        $partygoer = $this->getUser()->getPartygoer();

        if ($partygoer == null) {
            $this->addFlash('warning', "Veuillez d'abord vous connecter pour accéder à votre dashboard");
            return $this->redirectToRoute('homepage');
        }

        $parties = $partygoer->getCreatedEvents();
        $comments = $partygoer->getOwnComments();

        return $this->render('account_user/dashboard-parties.html.twig', [
            'parties'   =>  $parties,
            'comments'   =>  $comments,
            'partygoer'   =>  $partygoer,
        ]);
    }
}