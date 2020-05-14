<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted; //check les roles en annotation
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Entity\SportCategory;
use App\Form\CreateEventStep1Type;
use App\Form\CreateEventStep2Type;
use App\Form\CreateEventStep3Type;
use App\Form\CreateEventStep4Type;
use App\Form\CreateEventStep5Type;

class CreateEventController extends AbstractController{

	/**
	 * @Route("/creer-un-evenement/{step}", name="createEvent")
	 * @IsGranted("ROLE_USER")
	 */
	public function createEvent(EntityManagerInterface $em, $step, Request $request, SessionInterface $session )
	{
		if ( null !== $this->getUser() && in_array("ROLE_PRE_USER", $this->getUser()->getRoles() ) ) {
			return $this->redirectToRoute("app_user_infos_setup");
		}

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
						->setOrganiser($this->getUser())

						;  

						

					return $this->redirectToRoute("createEvent", ["step"=>"date-et-lieu"]);
				}




				return $this->render("createEventForm/step2.html.twig", [
					"createEventForm" => $formStep2->createView(),
					"sport" => $sport,
				]);

			break; 

			// Choix de la ville, de l'adresse, de la date et de l'heure du rendez vous
			case "date-et-lieu": 


				$formStep3 = $this->createform(CreateEventStep3Type::class);

				$formStep3->handleRequest($request); 					

				if($formStep3->isSubmitted() && $formStep3->isValid()){


					$data = $formStep3->getData();

					
					$this->session->get('sportEvent')
						->setLocationCity($data->getLocationCity())
						->setLocationAddress($data->getLocationAddress())
						->setLocationDescription($data->getLocationDescription())
						->setLocationDpt($data->getLocationDpt())
						->setDate($data->getDate())
						->setTimeStart($data->getTimeStart())
						->setTimeEnd($data->getTimeEnd());
					

				
					return $this->redirectToRoute("createEvent", ["step"=>"materiel-prix-niveau"]);
				}


				return $this->render("createEventForm/step3.html.twig", [
					"createEventForm" => $formStep3->createView(),
				]);
			break;

			// Choix du matériel, du prix et du niveau
			case "materiel-prix-niveau": 
				$formStep4 = $this->createForm(CreateEventStep4Type::class); 
				$formStep4->handleRequest($request); 

				if($formStep4->isSubmitted() && $formStep4->isValid()){
					$data = $formStep4->getData(); 
					$this->session->get('sportEvent')
						->setMaterial($data->getMaterial())
						->setLevel($data->getLevel())
						->setMaxPlayers($data->getMaxPlayers())  ; 
						
					if($data->getLevelDescription() === null)
					{
						$this->session->get('sportEvent')->setLevelDescription("");
					}else{
						$this->session->get('sportEvent')->setLevelDescription($data->getLevelDescription());
					}

					if($data->getPriceDescription() === null)
					{
						$this->session->get('sportEvent')->setPriceDescription("");
					}else{
						$this->session->get('sportEvent')->setPriceDescription($data->getPriceDescription());
					}
					 

					return $this->redirectToRoute("createEvent", ["step"=>"caracteristiques-complementaires"]);
				}

				return $this->render('createEventForm/step4.html.twig', [
					"createEventForm" => $formStep4->createView(),
				]); 
			break;

			case "caracteristiques-complementaires" :

				$formStep5 = $this->createForm(CreateEventStep5Type::class); 
				$formStep5->handleRequest($request); 

				if($formStep5->isSubmitted() && $formStep5->isValid()){
					$data = $formStep5->getData();

					$this->session->get('sportEvent')
						->setOtherAttributes($data->getOtherAttributes())
						; 



					$sportEvent = new SportEvent(); 
					$storedEvent = $this->session->get('sportEvent'); 

					$sportRepo = $em->getRepository(SportCategory::class);

					$sportCat = $sportRepo->findOneBy(["id" => $storedEvent->getSportCategory()->getId()]); 

					dump($sportCat); 


					$sportEvent->setTitle($storedEvent->getTitle())
							   ->setDescription($storedEvent->getDescription())
							   ->setOrganiser($this->getUser())
							   ->setLocationDpt($storedEvent->getLocationDpt())
							   ->setLocationCity($storedEvent->getLocationCity())
							   ->setLocationAddress($storedEvent->getLocationAddress())
							   ->setLocationDescription($storedEvent->getLocationDescription())
							   ->setThumbnail($storedEvent->getThumbnail())
							   ->addPlayer($this->getUser())
							   ->setLevel($storedEvent->getLevel())
							   ->setLevelDescription($storedEvent->getLevelDescription())
							   ->setMaterial($storedEvent->getMaterial())
							   ->setPriceDescription($storedEvent->getPriceDescription())
							   ->setCreatedAt(new \DateTime("now"))
							   ->setUpdatedAt(new \DateTime("now"))
							   ->setDate($storedEvent->getDate())
							   ->setTimeStart($storedEvent->getTimeStart())
							   ->setTimeEnd($storedEvent->getTimeEnd())
							   ->setSportCategory($sportCat)
							   ->setOtherAttributes($storedEvent->getOtherAttributes())
							   ->setMaxPlayers($storedEvent->getMaxPlayers())
					; 


					dump($sportEvent);	


					$em->persist($sportEvent);
					$em->flush(); 

					return $this->redirectToRoute("home"); 

				}

				return $this->render("createEventForm/step5.html.twig", [
					"createEventForm" => $formStep5->createView(), 
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