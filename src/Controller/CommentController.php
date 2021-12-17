<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
}
