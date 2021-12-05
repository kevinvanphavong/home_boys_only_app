<?php

namespace App\Controller\AccountUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("my-account", name="my_account")
 */
class AccountFavlistPartyController extends AbstractController {

    /**
     * @Route("/favlist-parties", name="_favlist_parties")
     */
    public function getFavlistPartyPage(): Response
    {
        $partygoer = $this->getUser()->getPartygoer();

        if($partygoer == null){
            $this->addFlash('warning', "Veuillez d'abord vous connecter pour accéder à votre favlist");
            return $this->redirectToRoute('homepage');
        }

        $favlistParties = $partygoer->getFavlistParties();
     
        return $this->render('account_user/favlist-party.html.twig', [
            'favlist'   =>  $favlistParties
        ]);
    }
}