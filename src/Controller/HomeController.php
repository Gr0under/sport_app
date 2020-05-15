<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;
use App\Entity\User;
use App\Form\SearchEventType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface; //pour générer des users en db only

class HomeController extends AbstractController{

	/**
	 * @Route("/", name="home")
	 */
	public function homepage(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
	{

		if ( null !== $this->getUser() && in_array("ROLE_PRE_USER", $this->getUser()->getRoles() ) ) {
			return $this->redirectToRoute("app_user_infos_setup");

		}
		$repository = $em->getRepository(SportEvent::class);

		$form = $this->createForm(SearchEventType::class);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$data = $form->getData();

			$events = $repository->findByDptOrCity($data['search']); 
			dd($events); 
		}


		$events = $repository->findAll();

		return $this->render("home.html.twig", [
			"events" => $events,
			"form" => $form->createView(), 
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

}