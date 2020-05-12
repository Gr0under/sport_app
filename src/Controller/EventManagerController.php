<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SportEvent;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class EventManagerController extends AbstractController
{
    /**
     * @Route("/event/join/{eventId}", name="app_join_event", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function joinEvent(EntityManagerInterface $em, $eventId)
    {
        $repo = $em->getRepository(SportEvent::class);

        $event = $repo->findOneBy(['id'=>$eventId]);

        $event->addPlayer($this->getUser());

        $em->persist($event);
        $em->flush(); 
        
        return $this->redirectToRoute("home"); 
    }


    /**
     * @Route("/event/list", name="app_list_event")
     * @IsGranted("ROLE_USER")
     */
    public function displayEventList(EntityManagerInterface $em)
    {
            
        return $this->render('/event_manager/eventList.html.twig'); 
    }
}
