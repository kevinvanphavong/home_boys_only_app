<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventCover;
use App\Entity\EventPicture;
use App\Entity\Partygoer;
use App\Form\EventType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class EventController extends AbstractController
{
    /**
     * @Route("/event/creation-new-party", name="creation-new-party")
     */
    public function newEvent(Request $request, UserRepository $userRepository): Response
    {
        $event =  new Event();
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);
        
        if ($eventForm->isSubmitted() && $eventForm->isValid()) {

            $complements1 = $eventForm->get('gatheringComplementsIncluded')->getData();
            foreach($complements1 as $complement) {
                $event->addGatheringComplementsIncluded($complement);
            }
            
            $complements2 = $eventForm->get('gatheringComplementsToBring')->getData();
            foreach($complements2 as $complement) {
                $event->addGatheringComplementsToBring($complement);
            }

            // handling each image uploaded for eventPictures
            $eventPictures = $eventForm->get('eventPictures')->getData();
            foreach ($eventPictures as $image) {
                $imageName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('event_pictures'), $imageName);
                $newEventPicture = new EventPicture();
                $newEventPicture->setName($imageName);
                $event->addEventPicture($newEventPicture);
            }
            
            // handling one image uploaded for eventCover
            $eventCover = $eventForm->get('eventCover')->getData();
            $coverName = md5(uniqid()) . '.' . $eventCover->guessExtension();
            $eventCover->move($this->getParameter('event_cover'), $coverName);
            $newEventCover = new EventCover();
            $newEventCover->setName($coverName);
            $event->setEventCover($newEventCover);

            $event->setPlanner($userRepository->find(51));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('event/event-creation-page.html.twig', [
            'eventForm' => $eventForm->createView()
        ]);
    }

    /**
     * @Route("/event/display/{id}/{title}", name="display-event")
     */
    public function displayEvent(Event $event): Response
    {        
        return $this->render('event/event-display-page.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/event/edit/{id}/{title}", name="edit-event")
     * @ParamConverter("event", options={"id" = "id"})
     */
    public function editEvent(Request $request, Event $event): Response
    {
        // $event =  new Event();
        $eventForm = $this->createForm(EventType::class, $event);
        // $eventForm->handleRequest($request);

        return $this->render('event/event-edit-page.html.twig', [
            'eventForm' => $eventForm->createView(),
            'party' => $event,
        ]);
    }

    /**
     * @Route("/event/edit/{eventId}/gatheringComplements", name="edit-event-check-gathering-complements")
     * @ParamConverter("event", options={"id" = "eventId"})
     */
    public function showGatheringComplementsChecked(Event $event)
    {
        $gatheringIncluded = $event->getGatheringComplementsToBring();
        $gatheringToBring = $event->getGatheringComplementsIncluded();

        return $this->json([
            'gatheringIncluded' => $gatheringIncluded,
            'gatheringToBring' => $gatheringToBring,
        ]);
    }

    /**
     * @Route("/event/set/{id}/favlist", name="event-set-to-favlist")
     */
    public function setEventToFavlist(Event $event, EntityManagerInterface $em): Response
    {
        $partygoer = $this->getUser()->getPartygoer();

        if ($partygoer->getFavlistParties()->contains($event)) {
            $partygoer->removeFavlistParty($event);
        } else {
            $partygoer->addFavlistParty($event);
        }

        $em->flush();

        return $this->json([
            'checkPartyInFavlist' => $partygoer->checkPartyInFavlist($event)
        ]);
    }

    /**
     * @Route("/event/{eventId}/settings/visibility", name="event-set-visibility", methods={"GET", "POST"})
     * @ParamConverter("event", options={"id" = "eventId"})
     */
    public function setEventVisibility(Event $event)
    {
        if ($this->getUser()->getPartygoer() === $event->getPlanner()){

            $event->setVisible(!$event->isVisible());
            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'visibility' => $event->isVisible()
            ]);
        }
    }

    /**
     * @Route("/event/{eventId}/settings/cancellation", name="event-set-cancellation", methods={"GET", "POST"})
     * @ParamConverter("event", options={"id" = "eventId"})
     */
    public function setEventCancellation(Event $event)
    {
        if ($this->getUser()->getPartygoer() === $event->getPlanner()){

            $event->setCanceled(!$event->isCanceled());
            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'cancellation' => $event->isCanceled()
            ]);
        }
    }
}

    
    // /**
    //  * @Route("/event/suppression/{id}/{title}/", name="suppression-event")
    //  */
    // public function showEvent(Request $request, UserRepository $userRepository): Response
    // {
    //     return;
    // }

