<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Form\CreateEventType;

class CreateEventController extends AbstractController{

	/**
	 * @Route("/creer-un-evenement/{step}", name="createEvent")
	 */
	public function createEvent(EntityManagerInterface $em, $step )
	{
		switch($step){
			case "choisir-un-sport":

				$createEventForm = $this->createform(CreateEventType::class);
				return $this->render("createEventForm/step1.html.twig", [
					"createEventForm" => $createEventForm->createView(),
				]);

			break;
		}

	
	}



}