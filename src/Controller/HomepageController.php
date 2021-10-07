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

        $event63 = $events->find(63);
        return $this->render('homepage.html.twig', [
            'events2' => $events->findBy([], [], 5, 12),
            'events1' => $events->findBy([], [], 5, 17),
            'events3' => $events->findBy([], [], 5, 10),
            'events4' => $events->findBy([], [], 5, 15),
            'comments' => $comments->findBy([], [], 5),
            'event63' => $event63,
        ]);
    }
}
