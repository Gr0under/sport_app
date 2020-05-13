<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Entity\User;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; //pour générer des users en db only

class HomeController extends AbstractController{

	/**
	 * @Route("/", name="home")
	 */
	public function homepage(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
	{

		if ( null !== $this->getUser() && in_array("ROLE_PRE_USER", $this->getUser()->getRoles() ) ) {
			return $this->redirectToRoute("app_user_infos_setup");
		}
		$repository = $em->getRepository(SportEvent::class);

		// if ( null !== $this->getUser() && in_array("ROLE_USER", $this->getUser()->getRoles() ) ){
		// 	$department = $this->getUser()->getAddress() ;



		// 	$eventsByCity = $repository->findBy(["location_dpt" => $department]);

		// 	return $this->render("home.html.twig", [
		// 		"events" => $eventsByCity
		// 	]);

		// 	dd($events); 
		// }
		$events = $repository->findAll();

		return $this->render("home.html.twig", [
			"events" => $events
		]);
	}

	/**
	 * @Route("/event-{slug}", name="event")
	 */
	public function displayEvent($slug, EntityManagerInterface $em){
		
		$eventId = $slug;
		
		$eventRepository = $em->getRepository(SportEvent::class);
		$event = $eventRepository->findOneBy(['id' => $eventId]);
		return $this->render("event.html.twig", [
			"event" => $event,
		]);

	}

	/**
	 * @Route("/organiserTest", name="organiser")
	 */
	public function organiserTest(EntityManagerInterface $em){

		$user = $this->getUser();
		$repo = $em->getRepository(SportEvent::class);

		$event = $repo->findOneBy(['id'=>"12"]);

		$event->setOrganiser($user);

		$em->persist($event);
		$em->flush(); 

		dd($user->getSportEventsOrganiser());

	}

}