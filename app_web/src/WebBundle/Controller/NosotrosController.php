<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NosotrosController extends Controller
{
	public function nosotrosAction(Request $request)
	{
		$session1 = $request->getSession();
        $session  = ($session1->get('admin'))? true: false;
		$em      = $this->getDoctrine()->getManager();

		$banner = $em->getRepository('WebBundle:Banner')->findBy(array('activo' => 1 ));

		return $this->render('WebBundle::nosotros.html.twig', array(
			'session' 	=> $session,
			'banner'	=> $banner,
			'pagina'	=> 'nosotros'
		));
	}
}