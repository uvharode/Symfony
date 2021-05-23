<?php

namespace App\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

/**
 * @Route("/login", name="app_login")
 */
public function login(AuthenticationUtils $authenticationUtils)
{
    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('Security/login.html.twig',[
        'last_username' => $lastUsername, 
        'error' => $error
    ]);
}

/**
 * @Route("/userDetails", name="userDetails")
 */
public function UserDetails()
{
    return $this->render('Security/userdetails.html.twig');
    
    // $product = $dm->getRepository(Product::class)->find($id);

    // if (! $product) {
    //     throw $this->createNotFoundException('No product found for id ' . $id);
    // }
}

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}