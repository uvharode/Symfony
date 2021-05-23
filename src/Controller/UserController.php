<?php

namespace App\Controller;

use App\Document\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/welcome", name="welcome")
     */
    public function showAction(Request $request)
    {
        {
            $user = [
                'NewApple' => '$1.16 trillion USD',
                'Samsung' => '$298.68 billion USD',
                'Microsoft' => '$1.10 trillion USD',
                'Alphabet' => '$878.48 billion USD',
                'Intel Corporation' => '$245.82 billion USD',
                'IBM' => '$120.03 billion USD',
                'Facebook' => '$552.39 billion USD',
                'Hon Hai Precision' => '$38.72 billion USD',
                'Tencent' => '$3.02 trillion USD',
                'Oracle' => '$180.54 billion USD',
            ];
    
            return $this->render('default/index.html.twig', [
                'users' => $user,
            ]);
        }
    }


    /**
     * @Route("/list", name="list")
     */
    public function list(Request $request)
    {
        $user = [
            'Apple' => '$1.16 trillion USD',
            'Samsung' => '$298.68 billion USD',
            'Microsoft' => '$1.10 trillion USD',
            'Alphabet' => '$878.48 billion USD',
            'Intel Corporation' => '$245.82 billion USD',
            'IBM' => '$120.03 billion USD',
            'Facebook' => '$552.39 billion USD',
            'Hon Hai Precision' => '$38.72 billion USD',
            'Tencent' => '$3.02 trillion USD',
            'Oracle' => '$180.54 billion USD',
        ];

        return $this->render('default/index.html.twig', [
            'users' => $user,
        ]);
    }
}