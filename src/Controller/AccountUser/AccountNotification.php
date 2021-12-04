<?php

namespace App\Controller\AccountUser;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("my-account", name="my_account")
 */
class AccountNotification extends AbstractController
{
    /**
     * @Route("/notifications", name="_notifications")
     */
    public function getNotificationsPage(): Response
    {
        $partygoerRecipient = $this->getUser()->getPartygoer();

        $notificationsAsGuest = $partygoerRecipient->getNotificationsAsGuest();

        return $this->render('account_user/notifications.html.twig', [
            'notificationsAsGuest' => $notificationsAsGuest
        ]);
    }
}