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
    
    public function getFavlistPartyPage(): Response
    {
        return $this->render('account_user/favlist-party.html.twig', []);
    }
}