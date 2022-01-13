<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventCover;
use App\Entity\EventPicture;
use App\Entity\Partygoer;
use App\Form\EventType;
use App\Repository\GatheringComplementIncludedRepository;
use App\Repository\GatheringComplementToBringRepository;
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
     * @Route("/event/display/{id}/{title}", name="display-event")
     */
    public function displayEvent(Event $event): Response
    {
        $arrayPathFolder = explode('/', $this->getParameter('profile_pictures'));
        $publicFolderProfilePicture = $arrayPathFolder[count($arrayPathFolder) - 2] . '/' . $arrayPathFolder[count($arrayPathFolder) - 1];

        return $this->render('event/event-display-page.html.twig', [
            'event' => $event,
            'publicFolderProfilePicture' => $publicFolderProfilePicture,
        ]);
    }

    /**
     * @Route("/event/creation-new-party", name="creation-new-party")
     */
    public function newEvent(Request $request): Response
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

            $event->setPlanner($this->getUser()->getPartygoer());
            
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
     * @Route("/event/edit/{id}/{title}", name="edit-event")
     * @ParamConverter("event", options={"id" = "id"})
     */
    public function editEvent(Request $request, Event $event): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
        
            $this->setEventFormPictures($eventForm, $event);
            $this->setEventFormCover($eventForm, $event);

            $entityManager->flush();
            $this->addFlash('success', 'Les modifications faites à votre soirée ont bien été prises en compte');
        }

        return $this->render('event/event-edit-page.html.twig', [
            'eventForm' => $eventForm->createView(),
            'party' => $event,
        ]);
    }

    /**
     * @Route("/event/gatherings/edit/{id}/", name="edit-event-gatherings")
     * @ParamConverter("event", options={"id" = "id"})
     */
    public function editEventOnlyGatheringsAside(Request $request, Event $event, GatheringComplementIncludedRepository $gatherginsIncludedRepo, GatheringComplementToBringRepository $gatheringsToBringRepo)
    {
        $messageContent = json_decode($request->getContent());

        $gatheringsIncludedBag = [];
        $gatheringsToBringBag = [];

        foreach ($messageContent[0] as $gatheringIcon) {
            $gatheringsIncludedBag[] = $gatherginsIncludedRepo->findOneBy(['icon' => $gatheringIcon]);
        }

        foreach ($messageContent[1] as $gatheringIcon) {
            $gatheringsToBringBag[] = $gatheringsToBringRepo->findOneBy(['icon' => $gatheringIcon]);
        }

        $this->setEventFormGatheringsComplements($event, null, $gatheringsIncludedBag, $gatheringsToBringBag);
        $this->getDoctrine()->getManager()->flush();

        return new Response();
    }

    public function setEventFormGatheringsComplements($event, $eventForm = null, $gatheringsIncludedBag = null, $gatheringsToBringBag = null)
    {
        if ($eventForm){    
            $complements1 = $eventForm->get('gatheringComplementsIncluded')->getData();
            if (count($complements1) > 0) {
                // Ajouter les nouveux compléments sélectionnés
                foreach ($complements1 as $complement) {
                    $event->addGatheringComplementsIncluded($complement);
                }
            }
            
            $complements2 = $eventForm->get('gatheringComplementsToBring')->getData();
            if (count($complements2) > 0) {
                // Ajouter les nouveux compléments sélectionnés
                foreach ($complements2 as $complement) {
                    $event->addGatheringComplementsToBring($complement);
                }
            }
        } else {
            if (isset($gatheringsIncludedBag)) {
                foreach ($event->getGatheringComplementsIncluded() as $complement) {
                    $event->removeGatheringComplementsIncluded($complement);
                }
                foreach ($gatheringsIncludedBag as $complement) {
                    $event->addGatheringComplementsIncluded($complement);
                }
            }
            if (isset($gatheringsToBringBag)) {
                foreach ($event->getGatheringComplementsToBring() as $complement) {
                    $event->removeGatheringComplementsToBring($complement);
                }
                foreach ($gatheringsToBringBag as $complement) {
                    $event->addGatheringComplementsToBring($complement);
                }
            }
        }
    }
    
    public function setEventFormPictures($eventForm, $event)
    {
        $entityManager = $this->getDoctrine()->getManager();
        // handling each image uploaded for eventPictures
        $eventPictures = $eventForm->get('eventPictures')->getData();
        if ($eventPictures) {
            // Supprimer les photos en public pour eventPictures
            foreach ($event->getEventPictures() as $oldEventPicture) {
                // unlink($this->getParameter('event_pictures') . '/' . $eventPicture->getName());
                $event->removeEventPicture($oldEventPicture);
                $entityManager->remove($oldEventPicture);
            }

            foreach ($eventPictures as $image) {
                $imageName = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('event_pictures'), $imageName);
                $newEventPicture = new EventPicture();
                $newEventPicture->setName($imageName);
                $event->addEventPicture($newEventPicture);
            }
        }
    }
    
    public function setEventFormCover($eventForm, $event)
    {
        // handling one image uploaded for eventCover
        $eventCover = $eventForm->get('eventCover')->getData();
        if ($eventCover) {
            $coverName = md5(uniqid()) . '.' . $eventCover->guessExtension();
            $eventCover->move($this->getParameter('event_cover'), $coverName);
            if ($event->getEventCover()) {
                unlink($this->getParameter('event_cover') . '/' . $event->getEventCover()->getName());
                $event->getEventCover()->setName($coverName);
            } else {
                $eventCover = new EventCover();
                $eventCover->setName($coverName);
                $eventCover->setEvent($event);
                $event->setEventCover($eventCover);
            }
        }
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
