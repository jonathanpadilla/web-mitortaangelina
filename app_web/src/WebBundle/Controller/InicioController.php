<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InicioController extends Controller
{
	public function inicioAction()
	{
		$session = true;

		return $this->render('WebBundle::inicio.html.twig', array(
			'session' => $session
			));
	}
}