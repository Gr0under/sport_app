<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Form\CreateEventStep1Type;
use App\Form\CreateEventStep2Type;
use App\Form\CreateEventStep3Type;

class CreateEventController extends AbstractController{

	/**
	 * @Route("/creer-un-evenement/{step}", name="createEvent")
	 */
	public function createEvent(EntityManagerInterface $em, $step, Request $request, SessionInterface $session )
	{

		$this->session = $session;
		if($this->session->get("sportEvent") === null)
		{
			$sportEvent = new SportEvent();
			$this->session->set('sportEvent', $sportEvent);
			echo "session créée";
		}

		switch($step){

			case "choisir-un-sport":
				

				$formStep1 = $this->createform(CreateEventStep1Type::class);
				$formStep1->handleRequest($request); 

				if($formStep1->isSubmitted() && $formStep1->isValid())
				{
					$data = $formStep1->getData();


					$this->session->get("sportEvent")->setTitle($data->getTitle());
					dump($this->session->get("sportEvent"));
					
					return $this->redirectToRoute("createEvent", ["step"=>"description"]);
				}

				return $this->render("createEventForm/step1.html.twig", [
					"createEventForm" => $formStep1->createView(),
				]);

			break;

			case "description":

				$formStep2 = $this->createform(CreateEventStep2Type::class);
				$formStep2->handleRequest($request); 

				if($formStep2->isSubmitted() && $formStep2->isValid()){
					$data = $formStep2->getData();
					$this->session->get("sportEvent")->setDescription($data->getDescription());  
					return $this->redirectToRoute("createEvent", ["step"=>"tout-le-reste"]);
				}

				return $this->render("createEventForm/step2.html.twig", [
					"createEventForm" => $formStep2->createView(),
				]);

			break; 

			case "tout-le-reste": 
				$formStep3 = $this->createform(CreateEventStep3Type::class);
				$formStep3->handleRequest($request); 

				if($formStep3->isSubmitted() && $formStep3->isValid()){

					$data = $formStep3->getData();
					$this->session->get('sportEvent')
						->setOrganiser($data->getOrganiser())
						->setlocationDpt($data->getlocationDpt())
						->setlocationCity($data->getlocationCity())
						->setLocationAddress($data->getLocationAddress())
						->setThumbnail($data->getThumbnail())
						->setPlayer($data->getPlayer())
						->setLevel($data->getLevel())
						->setLevelDescription($data->getLevelDescription())
						->setMaterial($data->getMaterial())
						->setAssemblyPoint($data->getAssemblyPoint())
						->setPriceDescription($data->getPriceDescription())
						->setDistance($data->getDistance())
						->setPace($data->getPace())
						->setCreatedAt($data->getCreatedAt())
						->setUpdatedAt($data->getUpdatedAt())
						->setDate($data->getDate())
						->setTimeStart($data->getTimeStart())
						->setTimeEnd($data->getTimeEnd());
					

					dump($this->session->get('sportEvent'));

					if(null !== $this->session->get('sportEvent'))
					{
						$em->persist($this->session->get('sportEvent')); 
						$em->flush();
					}else{
						echo "Aucun objet à envoyer en DB"; 
					}

					$this->session->remove('sportEvent');  
					dump($this->session->get('sportEvent'));

					 die();
					return $this->redirectToRoute("home");
				}


				return $this->render("createEventForm/step3.html.twig", [
					"createEventForm" => $formStep3->createView(),
				]);
			break;


		}

	
	}



}