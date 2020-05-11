<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegisterUserType; 
use App\Entity\User; 
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    /**
     * @Route("/inscription", name="app_register")
     */
    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {



    	$registerForm = $this->createForm(RegisterUserType::class);

    	$registerForm->handleRequest($request);

    	if($registerForm->isSubmitted() && $registerForm->isValid()){

    		$data = $registerForm->getData(); 

    		$user = new User();

    		$user->setEmail($data['email'])
    			->setPassword($passwordEncoder->encodePassword($user, $data['password']))
    			->setRoles(['ROLE_PRE_USER'])
    			->setFirstName('Polo')
    			; 

    		$em->persist($user);
    		$em->flush(); 

    		return $this->redirectToRoute("app_login"); 
    	}


        return $this->render('register/register.html.twig', [
            "registerForm" => $registerForm->createView(),
        ]);
    }
}
