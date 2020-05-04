<?php 

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController{

	/**
	 * @Route("/", name="home")
	 */
	public function homepage(){
		return $this->render("home.html.twig", []);
	}


}