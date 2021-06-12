<?php

namespace App\Controller;

use App\Entity\Memos;
use App\Form\MemosType;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MemosController extends AbstractController
{
    /**
     * @Route("/memos", name="memos")
     */
    public function index(Request $request, LoggerInterface $logger): Response
    {
        if ($this->getUser()===null) {
            return $this->redirectToRoute('index');
        }
        
        $logger->info('MemosController started working');
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(MemosType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $memoText = $data['memo'];
            $logger->info('Memo is submitted.');

            if(null !== $this->getUser()){
                if (0 == $this->getUser()->isVerified()) {
                    return $this->redirectToRoute('index');
                }else{
                    $memo = new Memos();
                    $memo->setUserId($this->getUser());
                    $memo->setMemo($memoText);
                    $memo->setCreatedAt(new \DateTime("now"));
                    $memo->setTrash(false);


                    $em->persist($memo);
                    $em->flush();
                }
            }
            
        }

        if ($this->getUser()) {
            $history = $this->getDoctrine()->getRepository(Memos::class)->findUserMemos($this->getUser()->getId());
        } else {
            $history = [];
        }

        return $this->render('memos/index.html.twig', [
            'form' => $form->createView(),
            'history' => $history,
        ]);
    }
}
