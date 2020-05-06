<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Entity\SportCategory;
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
			
		}

		switch($step){

			case "choisir-un-sport":
				

				$formStep1 = $this->createform(CreateEventStep1Type::class);
				
				$formStep1->handleRequest($request); 

				if($formStep1->isSubmitted() && $formStep1->isValid())
				{
					$data = $formStep1->getData();
					// dump($data->getCategory()->getSportName()); 

					$this->session->get("sportEvent")->setSportCategory($data->getSportCategory());
					
					
					return $this->redirectToRoute("createEvent", ["step"=>"description"]);
				}

				return $this->render("createEventForm/step1.html.twig", [
					"createEventForm" => $formStep1->createView(),
				]);

			break;

			// Choix du titre, de la description et de l'image
			case "description":

				$repository = $em->getRepository(SportCategory::class); 
				$sportId = $this->session->get("sportEvent")->getSportCategory()->getId();
				$sport = $repository->findOneBy(['id' => $sportId]); 

				$formStep2 = $this->createform(CreateEventStep2Type::class);
				$formStep2->handleRequest($request); 

				if($formStep2->isSubmitted() && $formStep2->isValid()){





					$data = $formStep2->getData();

					// Vérification que l'URL de l'image envoyée dans le formulaire existe bien dans l'objet SportCategory associé. Sinon, renvoie sur la page du formulaire en question.
					if(!in_array($data->getThumbnail(), $sport->getThumbnailCollection())){
						return $this->redirectToRoute("createEvent", ["step"=>"description"]);
					}
				

					$this->session->get("sportEvent")
						->setTitle($data->getTitle())
						->setDescription($data->getDescription())
						->setThumbnail($data->getThumbnail())

						;  
					dump($this->session->get("sportEvent")); die();

					return $this->redirectToRoute("createEvent", ["step"=>"tout-le-reste"]);
				}




				return $this->render("createEventForm/step2.html.twig", [
					"createEventForm" => $formStep2->createView(),
					"sport" => $sport,
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


	/**
	 * @Route("/json-test")
	 */
	public function jsonTest(){
		$photoCollection = [
			"0" => "/img/component/card/thumbnail_basket_1.jpg", 
			"1" => "/img/component/card/thumbnail_basket_2.jpg", 
			"2" => "/img/component/card/thumbnail_basket_3.jpg", 
			"3" => "/img/component/card/thumbnail_basket_4.jpg", 
		];


		$data = json_encode($photoCollection); 

		dump($data); 

		$data = json_decode($data); 
		dump($data); 

		foreach ($data as $v) {
			echo $v . "<br>"; 
		}

		die(); 
	}



	/**
	 * @Route("/update-sportcat")
	 */
	public function updateSportCat(EntityManagerInterface $em)
	{
		$sport = new SportCategory(); 
		$sport->setSportName('Pétanque')
			->setThumbnailCollection([
				"0" => "/img/component/card/thumbnail_petanque.jpg",  
			]); 

		$em->persist($sport);
		$em->flush(); 
		die(); 
	}



}