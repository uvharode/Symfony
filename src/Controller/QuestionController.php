<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController
{

 /**
  * @Route("/")
  */

    public function index()
    {
        return new Response('Hi Uv');
    }

    /**
     * @Route("/new_funct")
     */

    public function new_funct()
    {
        return new Response('Hi, you are on new page');

    }

    /**
     * @Route("/wildCard/{slug}")
     */

    public function wild_card($slug)
    {
        return new Response(sprintf(
            'Future page by wild card : "%s" ', 
            ucwords(str_replace('-',' ',$slug))
        ));
    }



}
