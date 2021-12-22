<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(EventRepository $events, CommentRepository $comments): Response
    {
        $upcomingEvents = [];
        for ($i=0; $i < 4; $i++) {
            $upcomingEvents[$i + 1] = $events->findBy([], [], 5, 5*$i);
        }

        return $this->render('homepage.html.twig', [
            'upcomingEvents1' => $upcomingEvents[1],
            'upcomingEvents2' => $upcomingEvents[2],
            'upcomingEvents3' => $upcomingEvents[3],
            'upcomingEvents4' => $upcomingEvents[4],
            'pastEvents1' => $upcomingEvents[1],
            'pastEvents2' => $upcomingEvents[2],
            'pastEvents3' => $upcomingEvents[3],
            'pastEvents4' => $upcomingEvents[4],
            // 'upcomingEvents1' => $events->getUpcomingEvents(5, 0),
            // 'upcomingEvents2' => $events->getUpcomingEvents(5, 5),
            // 'upcomingEvents3' => $events->getUpcomingEvents(5, 10),
            // 'upcomingEvents4' => $events->getUpcomingEvents(5, 15),
            // 'pastEvents1' => $events->getPastEvents(5, 0),
            // 'pastEvents2' => $events->getPastEvents(5, 5),
            // 'pastEvents3' => $events->getPastEvents(5, 10),
            // 'pastEvents4' => $events->getPastEvents(5, 15),
            'comments' => $comments->findBy([], [], 10),
        ]);
    }
}
