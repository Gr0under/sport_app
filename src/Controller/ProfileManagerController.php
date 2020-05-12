<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\UserInfosType; 
use App\Form\UserDescriptionType; 
use App\Entity\User; 
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


/**
 * @IsGranted("ROLE_USER")
 */
class ProfileManagerController extends AbstractController
{
    /**
     * @Route("/profile", name="app_profile_manager")
     */
    public function manageProfile()
    {
        return $this->render('profile_manager/userProfileManager.html.twig', [
            
        ]);
    }

    /**
     * @Route("/profile/mes-infos", name="app_manage_infos")
     */
    public function manageInfos(Request $request, EntityManagerInterface $em)
    {
    	$infosForm = $this->createForm(UserInfosType::class, $this->getUser());

    	$infosForm->handleRequest($request); 

    	if($infosForm->isSubmitted() && $infosForm->isValid())
    	{
    		$em->persist($this->getUser());
    		$em->flush();
    		return $this->redirectToRoute('app_profile_manager'); 

    	}
        return $this->render('register/userinfos.html.twig', [
            "registerForm" => $infosForm->createView(),
        ]);
    }


    /**
     * @Route("/profile/description", name="app_manage_description")
     */
    public function manageDescription(Request $request, EntityManagerInterface $em)
    {
    	$descriptionForm = $this->createForm(UserDescriptionType::class, $this->getUser());

    	$descriptionForm->handleRequest($request); 

    	if($descriptionForm->isSubmitted() && $descriptionForm->isValid())
    	{
    		$em->persist($this->getUser());
    		$em->flush();
    		return $this->redirectToRoute('app_profile_manager'); 

    	}
        return $this->render('register/userDescription.html.twig', [
            "descriptionForm" => $descriptionForm->createView(),
        ]);
    }
}
