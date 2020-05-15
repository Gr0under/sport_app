<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SportEvent;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\CreateEventStep1Type;
use App\Form\CreateEventStep2Type;
use App\Form\CreateEventStep3Type;
use App\Form\CreateEventStep4Type;
use App\Form\CreateEventStep5Type;


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


    /**
     * @Route("/event/manage/{id}", name="app_manage_event")
     */
    public function manageEvent(SportEvent $event)
    {
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        return $this->render('/event_manager/manageEvent.html.twig',[
                "event" => $event, 
        ]); 
    }


    /**
     * @Route("/event/manage/{id}/sport", name="app_manage_event_sport")
     */
    public function manageEventSport(SportEvent $event, EntityManagerInterface $em, Request $request)
    {
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep1Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('app_manage_event_infos', [ 'id' => $event->getId()] );
        }

        return $this->render('/event_manager/manageEventSport.html.twig',[
                "event" => $event, 
                "form" => $form->createView(), 
        ]); 
    }

    /**
     * @Route("/event/manage/{id}/infos", name="app_manage_event_infos")
     */
    public function manageEventInfos(SportEvent $event, EntityManagerInterface $em, Request $request)
    {

       
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep2Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "Les informations ont bien été mises à jour !"); 
            return $this->redirectToRoute('app_manage_event', ['id' => $event->getId()]);
        }

        return $this->render('/event_manager/manageEventInfos.html.twig',[
                "event" => $event, 
                "form" => $form->createView(),  
        ]); 
    }

    /**
     * @Route("/event/manage/{id}/date-lieu-horaires", name="app_manage_event_place")
     */
    public function manageEventPlace(SportEvent $event, EntityManagerInterface $em, Request $request)
    {
       
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep3Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "Les informations ont bien été mises à jour !"); 
            return $this->redirectToRoute('app_manage_event', ['id' => $event->getId()]);
        }

        return $this->render('/createEventForm/step3.html.twig',[
                "event" => $event, 
                "createEventForm" => $form->createView(), 
        ]); 
    }

    /**
     * @Route("/event/manage/{id}/materiel-niveau-prix", name="app_manage_event_material")
     */
    public function manageEventMaterial(SportEvent $event, EntityManagerInterface $em, Request $request)
    {
       
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep4Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "Les informations ont bien été mises à jour !"); 
            return $this->redirectToRoute('app_manage_event', ['id' => $event->getId()]);
        }

        return $this->render('/event_manager/manageEventMaterial.html.twig',[
                "event" => $event, 
                "createEventForm" => $form->createView(), 
        ]); 
    }


    /**
     * @Route("/event/manage/{id}/autres-caracteristiques", name="app_manage_event_other_attributes")
     */
    public function manageEventOtherAttributes(SportEvent $event, EntityManagerInterface $em, Request $request)
    {
       
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep5Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "Les informations ont bien été mises à jour !"); 
            return $this->redirectToRoute('app_manage_event', ['id' => $event->getId()]);
        }

        return $this->render('/createEventForm/step5.html.twig',[
                "event" => $event, 
                "createEventForm" => $form->createView(), 
        ]); 
    }

    /**
     * @Route("/event/manage/{id}/contact-player", name="app_manage_contact_player")
     */
    public function manageEventContactPlayer(SportEvent $event, EntityManagerInterface $em, Request $request)
    {
       
        $this->denyAccessUnlessGranted('MANAGE', $event); 

        $form = $this->createForm(CreateEventStep5Type::class, $event);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', "Les informations ont bien été mises à jour !"); 
            return $this->redirectToRoute('app_manage_event', ['id' => $event->getId()]);
        }

        return $this->render('/createEventForm/step5.html.twig',[
                "event" => $event, 
                "createEventForm" => $form->createView(), 
        ]); 
    }



}
