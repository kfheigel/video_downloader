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
     * @param Request $request
     * @param LoggerInterface $logger
     * @param Downloader $youtubeDownload
     * @return Response
     * @Route("/downloader", name="downloader")
     */
    public function index(Request $request, LoggerInterface $logger, Downloader $youtubeDownload): Response
    {
        if(!$this->getUser()==null && $this->getUser()->isVerified()==0){
            return $this->redirectToRoute('index');
        }
        $logger->info('IndexController started working');

        $form = $this->createForm(VideoDownloadType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $videoLink = $data['input'];

            $logger->info('Form is submitted');
            $links = $youtubeDownload->downloadVideo($videoLink);
            $videoId = $youtubeDownload->videoId($videoLink);
            $videoTitle = $youtubeDownload->videoTitle($videoLink);
        } else {
            $links = '';
            $videoId = '';
            $videoLink = '';
            $videoTitle = '';
        }

        return $this->render('downloader/index.html.twig', [
            'form' => $form->createView(),
            'links' => $links,
            'videoId' => $videoId,
            'videoLink' => $videoLink,
            'videoTitle' => $videoTitle,
        ]);
    }
}
