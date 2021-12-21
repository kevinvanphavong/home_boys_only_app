<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Invitation;
use App\Entity\Partygoer;
use App\Repository\InvitationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class InvitationController extends AbstractController
{
    /**
     * @Route("/event/{eventId}/send/invitation/request/{partygoerGuestId}", name="send_invitation_request")
     * @ParamConverter("event", options={"id" = "eventId"})
     * @ParamConverter("partygoerGuest", options={"id" = "partygoerGuestId"})
     */
    public function sendInvitationRequest(Request $request, Event $event, Partygoer $partygoerGuest, InvitationRepository $invitationRepository)
    {
        $invitationAlreadyExist = $invitationRepository->findOneBy(
            [
                'partygoerGuest' => $partygoerGuest->getId(),
                'partygoerEventPlanner' => $event->getPlanner(),
                'event' => $event
            ]
            );

        if ($invitationAlreadyExist) {

            $successMessage =
                "Vous avez deja envoyé une demande d'invitation : "
                . '<b>' . $event->getTitle() . '</b> ! <br>'
                . $event->getPlanner()->getFirstname() . ' ' . $event->getPlanner()->getLastname()
                . " vous donnera une réponse au plus vite ;)";

            return $this->json([
                'successMessage' => $successMessage,
                'backgroundColor' => 'bg-danger'
            ]);
        } else {
            $messageContent =
                $partygoerGuest->getFirstname() . ' ' . $partygoerGuest->getLastname()
                . " vous a envoyé une demande d'invitation pour la soirée  : "
                . $event->getTitle() . ' du ' .  $event->getStartingDate()->format('d/m/Y');

            $successMessage =
                "Votre demande d'invitation à bien été envoyé pour la soirée : "
                . '<b>' . $event->getTitle() . '</b> ! <br>'
                . $event->getPlanner()->getFirstname() . ' ' . $event->getPlanner()->getLastname()
                . " vous donnera une réponse au plus vite ;)";

            $invitation = new Invitation();
            $invitation->setEvent($event);
            $invitation->setPartygoerEventPlanner($event->getPlanner());
            $invitation->setPartygoerGuest($partygoerGuest);
            $invitation->setIsMaking(false);
            $invitation->setIsRequest(true);
            $invitation->setContent($messageContent);
            $partygoerGuest->addInvitationsRequest($invitation);

            $this->getDoctrine()->getManager()->persist($invitation);
            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'successMessage' => $successMessage,
                'backgroundColor' => 'bg-success'
            ]);
        }
    }

    /**
     * @Route("/invitation/{invitId}/settings/acceptation", name="invit_set_acceptation", methods={"GET", "POST"})
     * @ParamConverter("invitation", options={"id" = "invitId"})
     */
    public function setCommentVisiblity(Invitation $invitation)
    {
        if ($this->getUser()->getPartygoer() === $invitation->getPartygoerEventPlanner()) {

            $invitation->setIsAccepted(!$invitation->isAccepted());

            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'acceptation' => $invitation->isAccepted()
            ]);
        }
    }
}