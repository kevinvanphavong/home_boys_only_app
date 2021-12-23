<?php

namespace App\Service;

use App\Entity\Partygoer;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;

class DashboardPartyService
{
    public function getAllDatesFromMyEvents(EventRepository $eventRepository, Partygoer $partygoer)
    {
        $arrayDatesFromEvents = $eventRepository->getAllDateFromEvents($partygoer->getId());

        $arrayDatesGroupByDate = [];
        foreach ($arrayDatesFromEvents as $eventDate) {
            foreach ($eventDate as $date) {
                $arrayDatesGroupByDate[$date->format('m-Y')] = $date;
            }
        }

        return $arrayDatesGroupByDate;
    }

    public function getAllEventTitleFromMyComments(CommentRepository $commentRepository, Partygoer $partygoer)
    {
        $comments = $commentRepository->getAllEventRelatedToComment($partygoer);

        $arrayEventTitleComment = [];

        foreach ($comments as $comment) {
            $arrayEventTitleComment[$comment->getEvent()->getId()] = [
                'title' => $comment->getEvent()->getTitle(),
                'id' => $comment->getEvent()->getId(),
            ];
        }

        // dd($arrayEventTitleComment);
        return $arrayEventTitleComment;
    }
}