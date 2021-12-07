<?php

namespace App\Controller\AccountUser;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**`
 * @Route("my-account", name="my_account")
 */
class AccountRecentPartyController extends AbstractController
{
    /**
     * @Route("/recents-parties", name="_recents-parties")
     */
    public function getRecentPartyPage(): Response
    {
        return $this->render('account_user/recents-parties.html.twig');
    }
}