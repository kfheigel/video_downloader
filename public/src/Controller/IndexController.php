<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        if (null == !$this->getUser() && 0 == $this->getUser()->isVerified()) {
            $this->addFlash(
                'danger',
                "Ooops! You have to verify your e-mail adress to access service content! Link is in the mail! Check Spam if you can't find it, or contact me through the contact form!"
            );
        }
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(
                ['isVerified' => '1']
            );

        return $this->render('index/index.html.twig', [
            'userCount' => count($users)
        ]);
    }
}
