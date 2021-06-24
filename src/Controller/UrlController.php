<?php

namespace App\Controller;

// ini_set('memory_limit', '3G');

use App\Entity\Url;
use App\Form\UrlType;
use App\Repository\UrlRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/url")
 */
class UrlController extends AbstractController
{
    /**
     * @Route("/", name="url_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em): Response
    {   
     
        // $repository = $this->getDoctrine()->getRepository(Url::class);
        $repository = $em->getRepository(Url::class);
        $urls = $repository->findAll();

        return $this->render('url/index.html.twig', [
            'baseUrl'=>$_SERVER['SERVER_NAME'],
            'urls' => $urls
        ]);
    }

    

    /**
     * @Route("/new", name="url_new", methods={"GET"})
     */
    public function new(Request $request): Response
    {
        return $this->render('url/new.html.twig', []);
    }

    /**
     * @Route("/create", name="url_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $url = new Url();
        $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($url);
        //     $entityManager->flush();
        $urlId = substr(md5(uniqid(rand(), true)),0,9);
        $urlRedirect = $request->request->get('url');

        $url = new Url();
        $url->setUrl($urlRedirect);
        $url->setShortCode($urlId);
        $url->setAddedDate(new \DateTime());
        $url->setRedirectUrl($urlRedirect);
        
        $entityManager->persist($url);        
        $entityManager->flush();

          return $this->render('url/new_url.html.twig', [
            'baseUrl'=>$_SERVER['SERVER_NAME'],
            'urlId'=>$urlId,
            'urlRedirect'=>$urlRedirect
        ]);
    }

    /**
     * @Route("/{id}", name="url_show", methods={"GET"})
     */
    public function show(Url $url): Response
    {
        return $this->render('url/show.html.twig', [
            'url' => $url,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="url_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Url $url): Response
    {
        $form = $this->createForm(UrlType::class, $url);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('url_index');
        }

        return $this->render('url/edit.html.twig', [
            'url' => $url,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="url_delete", methods={"POST"})
     */
    public function delete(Request $request, Url $url): Response
    {
        if ($this->isCsrfTokenValid('delete'.$url->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($url);
            $entityManager->flush();
        }

        return $this->redirectToRoute('url_index');
    }
}
