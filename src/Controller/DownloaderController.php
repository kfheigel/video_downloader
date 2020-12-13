<?php

namespace App\Controller;

use App\Form\VideoDownloadType;
use App\Service\Downloader;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DownloaderController extends AbstractController
{
    /**
     * @Route("/downloader", name="downloader")
     */
    public function index(Request $request, LoggerInterface $logger, Downloader $youtubeDownload): Response
    {
        $logger->info('IndexController started working');

        $form = $this->createForm(VideoDownloadType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $videoLink = $data['input'];

            $logger->info('Form is submitted');
            $links = $youtubeDownload->downloadVideo($videoLink);
            $videoId = $youtubeDownload->videoId($videoLink);
        } else {
            $links = '';
            $videoId = '';
        }

        return $this->render('downloader/index.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
            'videoId' => $videoId,
        ]);
    }
}
