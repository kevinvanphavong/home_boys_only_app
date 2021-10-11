<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\EventCover;
use App\Entity\EventPicture;
use App\Form\EventType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

        // dd($eventForm, $request);
        
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
            $newEventCover->setName($imageName);
            $event->setEventCover($newEventCover);

            $event->setPlanner($userRepository->find(51));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('event/event-creation-page.html.twig', [
            'controller_name' => 'EventController',
            'eventForm' => $eventForm->createView()
        ]);
    }
}
