<?php

namespace App\Controller;

use App\Document\User;
use App\Form\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    
    // /**
    //  * @Route("/Create", name="create")
    //  */
    // public function createAction(DocumentManager $dm, HttpFoundationRequest $request)
    // {
    //     $form = $this->createForm(RegistrationType::class, new Registration());
    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid())
    //     {
    //         $registration = $form->getData();

    //         $dm->persist($registration->getUser());
    //         $dm->flush();

    //         return new Response("Successfully Register");
    //     }

    //     return $this->render('Account/register.html.twig',[
    //         'form' => $form->createView()
    //     ]);
    // }

    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/Register", name="register")
     */
    public function register(HttpFoundationRequest $request, DocumentManager $dm)
    {
        // Create a new blank user and process the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            // Encode the new users password
            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user, $user->getPlainPassword()
                )
            );

            // Set their role
            $user->setRole('ROLE_USER');

            //dd($user);
            // Save
            $dm->persist($user);
            $dm->flush();

            return $this->redirectToRoute('userDetails');
        }

        return $this->render('Account/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }



}