<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\Partygoer;
use App\Repository\ConversationRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class AccountUserController extends AbstractController
{
    // my-account/party/creation
    // my-account/party/edition/{event.id}/{event.name}

    // ----------

    // my-account/notifications         (page des notifications)
    // my-account/direct-messages       (page des messages privées avec un organisateur de soirée)

    // my-account/profil/edition        (page des informations personnelles modifiables)
    // my-account/party/dashboard       (page deu dashboard)

    // my-account/favlist-invitations   (page des favlist et invitations)
    // my-account/last-events           (page des dernières soirées)

    /**
     * @Route("my-account/direct-messages", name="my_account_direct_messages")
     */
    public function getDirectMessagesPage(ConversationRepository $conversationRepository): Response
    {
        $user = $this->getUser();

        $convs = $conversationRepository->findAllTheConversation($user->getPartygoer());

        return $this->render('account/direct-messages.html.twig', [
            'user' => $user,
            'convs' => $convs,
        ]);
    }

    /**
     * @Route("/send-message/{authorId}/{convId}", name="send_message", methods={"GET", "POST"})
     * @ParamConverter("author", options={"id" = "authorId"})
     * @ParamConverter("conversation", options={"id" = "convId"})
     */
    public function sendMessage(Request $request, Partygoer $author, Conversation $conversation)
    {
        $messageContent = $request->getContent();

        if($conversation->getUserGuest() == $author){
            $recipient = $conversation->getUserPlanner();
        } else {
            $recipient = $conversation->getUserGuest();
        }
        
        if($request && $messageContent){
            $dateTime = new DateTime();
            $message = new Message();
            $message->setAuthor($author);
            $message->setRecipient($recipient);
            $message->setContent($messageContent);
            $message->setCreatedAt($dateTime);
            $message->setSendAt($dateTime);
            $message->setConversation($conversation);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->json([
                'messageContent' => $messageContent,
                'recipientFirstname' => $recipient->getFirstname(),
                'recipientLastname' => $recipient->getLastname(),
                'messageSendAt' => $dateTime->format('d-m-Y H:i')
            ]);
        } else {
            return $this->json([
                '500' => "La requête n'a pas été récupéré",
            ]);
        }

    }
}