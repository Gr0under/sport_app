<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegisterUserType; 
use App\Form\UserInfosType; 
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


    		$user->setEmail($data->getEmail())
    			->setPassword($passwordEncoder->encodePassword($user, $data->getPassword()))
    			->setRoles(['ROLE_PRE_USER'])
    			; 

    		$em->persist($user);
    		$em->flush(); 

    		return $this->redirectToRoute("app_login"); 
    	}


        return $this->render('register/register.html.twig', [
            "registerForm" => $registerForm->createView(),
        ]);
    }


    /**
     * @Route("/inscription/mes-infos", name="app_user_infos_setup")
     * @IsGranted("ROLE_USER")
     */
    public function setupInfos(Request $request, EntityManagerInterface $em ){
        $registerForm = $this->createForm(UserInfosType::class, $this->getUser());

        $registerForm->handleRequest($request); 

        if($registerForm->isSubmitted() && $registerForm->isValid())
        {
            $data = $registerForm->getData();

            $user = $this->getUser();

            $user->setFullName($data->getFullName())
                ->setPseudo($data->getPseudo())
                ->setBirthdate($data->getBirthdate())
                ->setAddress($data->getAddress())
                ->setGender($data->getGender())
                ->setRoles([])
                ;

            $em->persist($user);

            $em->flush(); 

            return $this->redirectToRoute("home");  

        }

        return $this->render('/register/userinfos.html.twig', [

            "registerForm" => $registerForm->createView(),  

        ]); 
    }
}
