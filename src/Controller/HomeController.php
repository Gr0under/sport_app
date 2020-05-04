<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SportEvent;

class HomeController extends AbstractController{

	/**
	 * @Route("/", name="home")
	 */
	public function homepage(EntityManagerInterface $em)
	{
		$repository = $em->getRepository(SportEvent::class);
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
		dump($event);
		return $this->render("event.html.twig", [
			"event" => $event,
		]);

	}



	/**
	 * @Route("/register_event")
	 */
	public function registerEvent(EntityManagerInterface $em)
	{
		$sportEvent = new SportEvent();

		$sportEvent->setTitle('match de basket')
		->setDescription('Match de basket amical samedi 2 mai au stade Yannick Noah à Cergy le haut. Sur demi terrain ou terrain complet en fonction du nombre de participants. Ouvert à tous mais il serait préférable d’avoir déjà joué au basket avant de vous décider à vous inscrire. ')
		->setOrganiser('Paul Juk')
		->setDate(new \DateTime(date("d/m/Y", time()+(2*24*60*60))))
		->setTimeStart(new \DateTime("now"))
		->setTimeEnd(new \DateTime("now"))
		->setLocationDpt('95')
		->setLocationCity('Cergy Le Haut')
		->setLocationAddress('8 cours des merveilles 95800 Cergy le haut')
		->setThumbnail('/img/component/card/thumbnail_basket.jpg')
		->setPlayer('Paul, Clément, Vincent')
		->setLevel('Tous niveaux')
		->setLevelDescription('Attention, ce n’est pas un cours d’initiation. Il est conseillé d’avoir déjà joué pour rejoindre cet évènement.')
		->setMaterial("Tenue adaptée; Basket d’intérieure; Bouteille d’eau")
		->setAssemblyPoint("Parking du Stade Yannick Noah à Cergy Le Haut, l’adresse exacte est accessible pour les personnes inscrites.")
		->setPriceDescription("20€ pour la location du terrain, à diviser en fonction du nombre de participant.")
		->setCreatedAt(new \DateTime("now"))
		->setUpdatedAt(new \DateTime("now")) ;

		echo "<pre>";
		dump($sportEvent); 	
		echo "</pre>"; 

		$em->persist($sportEvent);
		$em->flush();
		die();
	}


}