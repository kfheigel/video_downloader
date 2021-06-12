<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserHistory;
use App\Entity\UrlShortener;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteAccountController extends AbstractController
{
    /**
     * @Route("/account/delete", name="delete_account")
     */
    public function index(Session $session, LoggerInterface $logger): Response
    {
        if ($this->getUser()===null) {
            return $this->redirectToRoute('index');
        }
        $em = $this->getDoctrine()->getManager();
        $user_id = $this->getUser()->getId();

        $session = $this->get('session');
        $session = new Session();
        $session->invalidate();

        if ($this->getUser()) {
            
            $user = $em->getReference(User::class, $user_id);
            $userHistory = $em->getReference(UserHistory::class, $user_id);
            $urlShortener = $em->getReference(UrlShortener::class, $user_id);
            $user->removeUserHistory($userHistory);
            $user->removeUrlShortener($urlShortener);
            $em->remove($user);
            $em->flush();

            $logger->info('User has been deleted ' . $user_id);
        }
        return $this->redirectToRoute('index');
    }
}
