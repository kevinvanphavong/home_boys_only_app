<?php

namespace App\Service;

use App\Entity\Partygoer;
use App\Repository\CommentRepository;
use App\Repository\EventRepository;
use App\Repository\InvitationRepository;

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
                'startingDate' => $comment->getEvent()->getStartingDate(),
            ];
        }

        return $arrayEventTitleComment;
    }
    
    public function getAllEventTitleFromMyInvits(InvitationRepository $invitationRepository, Partygoer $partygoer)
    {
        $invits = $invitationRepository->getAllEventRelatedToInvit($partygoer);

        $arrayEventTitleComment = [];

        foreach ($invits as $invit) {
            $arrayEventTitleComment[$invit->getEvent()->getId()] = [
                'title' => $invit->getEvent()->getTitle(),
                'id' => $invit->getEvent()->getId(),
                'startingDate' => $invit->getEvent()->getStartingDate(),
            ];
        }

        return $arrayEventTitleComment;
    }
}