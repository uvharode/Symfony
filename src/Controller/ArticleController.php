<?php

namespace App\Controller;

use App\Document\Article;
use App\Form\Type\ArticleType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function demo(HttpFoundationRequest $request, DocumentManager $dm)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

         if($form->isSubmitted() && $form->isValid()) {

            $article = $form->getData();
            
          // dd($article);
            $dm->persist($article);
            $dm->flush(); 

             return $this->redirectToRoute('ShowArticle');
         }
       
        return $this->render('Article/article.html.twig',[
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/ShowArticle", name = "ShowArticle")
     */
    public function showArticle()
    {
        return new Response("Success Article");
    }
}