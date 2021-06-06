<?php

namespace App\Controller;

use DateTime;
use App\Entity\UrlShortener;
use Psr\Log\LoggerInterface;
use App\Form\UrlShortenerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UrlShortenerController extends AbstractController
{
    /**
     * @Route("shortener", name="shortener")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $logger->info('IndexController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(UrlShortenerType::class);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $longLink = $data['url'];
            $logger->info('Form is submitted. Link to shorten: ' . $longLink);
            $url_short = uniqid(); 

            $shortener = new UrlShortener();
            $shortener->setUrlLong($longLink);
            $shortener->setUrlShort($url_short);
            $shortener->setCreatedAt(new \DateTime("now"));
            if ($this->getUser()) {
                $shortener->setUserId($this->getUser());
            }

            $em->persist($shortener);
            $em->flush();
        }else {
            $url_short = '';
        }
        
        return $this->render('url_shortener/index.html.twig', [
            'form' => $form->createView(),
            'url_short' => $url_short,
        ]);
    }

    /**
     * @Route("/short/{url}", name="url_redirect")
     */
    public function url_short_redirect(string $url): Response
    {
        $repository = $this->getDoctrine()->getRepository(UrlShortener::class);
        $result = $repository->findOneBy([
            'url_short' => $url,
        ]);
        return $this->redirect($result->getUrlLong());
    }
}
