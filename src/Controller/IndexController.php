<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use App\Form\VideoDownloadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $logger->info('IndexController started working');

        $form = $this->createForm(VideoDownloadType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }else{
            $data['input'] = 'kaka';
        }

        return $this->render('index/index.html.twig', [
            'form' => $form->createView(),
            'link' => $data['input'],
        ]);
    }
}
