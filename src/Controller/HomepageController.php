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
        return $this->render('homepage.html.twig', [
            'upcomingEvents1' => $events->findBy([], [], 5),
            'upcomingEvents2' => $events->findBy([], [], 5),
            'upcomingEvents3' => $events->findBy([], [], 5),
            'upcomingEvents4' => $events->findBy([], [], 5),
            'pastEvents1' => $events->findBy([], [], 5),
            'pastEvents2' => $events->findBy([], [], 5),
            'pastEvents3' => $events->findBy([], [], 5),
            'pastEvents4' => $events->findBy([], [], 5),
            // 'upcomingEvents1' => $events->getUpcomingEvents(5, 0),
            // 'upcomingEvents2' => $events->getUpcomingEvents(5, 5),
            // 'upcomingEvents3' => $events->getUpcomingEvents(5, 10),
            // 'upcomingEvents4' => $events->getUpcomingEvents(5, 15),
            // 'pastEvents1' => $events->getPastEvents(5, 0),
            // 'pastEvents2' => $events->getPastEvents(5, 5),
            // 'pastEvents3' => $events->getPastEvents(5, 10),
            // 'pastEvents4' => $events->getPastEvents(5, 15),
            'comments' => $comments->findBy([], [], 5),
        ]);
    }
}
