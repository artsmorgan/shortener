<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Url;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/u/{slug}", name="url_redirecturl", methods={"GET"})
     */
    public function redirectUrl(string $slug,EntityManagerInterface $em): Response
    {   
     
        $repository = $this->getDoctrine()->getRepository(Url::class);
        $repository = $em->getRepository(Url::class);
        $urls = $repository->findOneBy(['short_code' => $slug]);
        $redirectUrl = '';
        $hasRedirect=false;
        if(isset($urls)){
            $hasRedirect = true; 
            $count = $urls->getHits() + 1;               
            $urls->setHits($count);
            $redirectUrl = $urls->getRedirectUrl();
            $em->persist($urls);
            $em->flush();      
        }
        


        return $this->render('url/redirect.html.twig', [
            'slug' => $slug,
            'hasRedirect'=> $hasRedirect,
            'redirectUrl'=>$redirectUrl
        ]);
    }
}
