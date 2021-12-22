<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Event;
use App\Entity\Partygoer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/{commentId}/settings/visibility", name="comment-set-visibility", methods={"GET", "POST"})
     * @ParamConverter("comment", options={"id" = "commentId"})
     */
    public function setCommentVisiblity(Comment $comment)
    {
        if ($this->getUser()->getPartygoer() === $comment->getEvent()->getPlanner()) {

            $comment->setVisible(!$comment->isVisible());

            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                'visibility' => $comment->isVisible()
            ]);
        }
    }

    /**
     * @Route("/new-comment/event/{eventId}/authorComment/{authorId}", name="my_account_send_comment", methods={"GET", "POST"})
     * @ParamConverter("event", options={"id" = "eventId"})
     * @ParamConverter("partygoerAuthor", options={"id" = "authorId"})
     */
    public function sendCommentForEvent(Request $request, Event $event, Partygoer $partygoerAuthor): Response
    {
        if ($request){            
            $backgroundColor = 'bg-warning';
            $successMessage = "Votre commentaire a bien été enregistré ! <br><h5>Nice baby girl !</h5>" ;
            
            $messageContent = $request->getContent();
            $comment = new Comment();
            $comment->setAuthor($partygoerAuthor);
            $comment->setEvent($event);
            $comment->setContent($messageContent);

            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            return $this->json([
                "messageContent" => $successMessage,
                "backgroundColor" => $backgroundColor,
            ]);
        }        
    }
}