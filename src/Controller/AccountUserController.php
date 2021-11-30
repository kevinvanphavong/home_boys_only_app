<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountUserController extends AbstractController
{
    // my-account/party/creation
    // my-account/party/edition/{event.id}/{event.name}

    // ----------

    // my-account/notifications         (page des notifications)
    // my-account/direct-messages       (page des messages privées avec un organisateur de soirée)

    // my-account/profil/edition        (page des informations personnelles modifiables)
    // my-account/party/dashboard       (page deu dashboard)

    // my-account/favlist-invitations   (page des favlist et invitations)
    // my-account/last-events           (page des dernières soirées)

    /**
     * @Route("my-account/direct-messages", name="my_account_direct_messages")
     */
    public function getNotificationsPage(): Response
    {
        return $this->render('account/direct-messages.html.twig');
    }
}