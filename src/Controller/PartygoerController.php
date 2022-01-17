<?php

namespace App\Controller;

use App\Entity\Partygoer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partygoer", name="partygoer")
 */
class PartygoerController extends AbstractController
{
    /**
     * @Route("/profile/{partygoerId}", name="_profile_page")
     * @ParamConverter("partygoer", options={"id" = "partygoerId"})
     */
    public function index(Request $request, Partygoer $partygoer): Response
    {
        $arrayPathFolder = explode('/', $this->getParameter('profile_pictures'));
        $publicFolderProfilePicture = $arrayPathFolder[count($arrayPathFolder) - 2] . '/' . $arrayPathFolder[count($arrayPathFolder) - 1];

        return $this->render('partygoer/partygoer-profile.html.twig', [
            "partygoer" => $partygoer,
            "publicFolderProfilePicture" => $publicFolderProfilePicture
        ]);
    }
}
