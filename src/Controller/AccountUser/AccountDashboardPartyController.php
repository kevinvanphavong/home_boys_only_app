<?php

namespace App\Controller\AccountUser;

use App\Entity\Event;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use App\Repository\InvitationRepository;
use App\Service\DashboardPartyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function getDashboardPartyPage(CommentRepository $commentRepository, InvitationRepository $invitationRepository, EventRepository $eventRepository, DashboardPartyService $dashboardPartyService): Response
    {
        $partygoer = $this->getUser()->getPartygoer();

        if ($partygoer == null) {
            $this->addFlash('warning', "Veuillez d'abord vous connecter pour accéder à votre dashboard");
            return $this->redirectToRoute('homepage');
        }

        $parties = $partygoer->getCreatedEvents();
        $comments = $commentRepository->findAllCommentsOnMyParties($partygoer);
        $invitations = $invitationRepository->findBy(
            [
                'isMaking' => false,
                'isRequest' => true,
                'partygoerEventPlanner' => $partygoer,
            ]
        );

        $arrayPathFolder = explode('/', $this->getParameter('profile_pictures'));
        $publicFolderProfilePicture = $arrayPathFolder[count($arrayPathFolder) - 2] . '/' . $arrayPathFolder[count($arrayPathFolder) - 1];

        $arrayPathFolder = explode('/', $this->getParameter('event_cover'));
        $publicFolderEventCover = $arrayPathFolder[count($arrayPathFolder) - 2] . '/' . $arrayPathFolder[count($arrayPathFolder) - 1];

        $arrayDatesFromEvents = $dashboardPartyService->getAllDatesFromMyEvents($eventRepository, $partygoer);
        $arrayEventTitleFromComments = $dashboardPartyService->getAllEventTitleFromMyComments($commentRepository, $partygoer);

        return $this->render('account_user/dashboard-parties.html.twig', [
            'parties'   =>  $parties,
            'comments'   =>  $comments,
            'invitations'   =>  $invitations,
            'partygoer'   =>  $partygoer,
            'publicFolderProfilePicture'   =>  $publicFolderProfilePicture,
            'publicFolderEventCover'   =>  $publicFolderEventCover,

            'arrayDatesFromEvents'   =>  $arrayDatesFromEvents,
            'arrayEventTitleFromComments'   =>  $arrayEventTitleFromComments,
        ]);
    }
}