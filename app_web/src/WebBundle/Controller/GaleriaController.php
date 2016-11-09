<?php
namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GaleriaController extends Controller
{
	
	public function galeriaAction(Request $request)
	{
		$session1 = $request->getSession();
        $session  = ($session1->get('admin'))? true: false;
		$em      = $this->getDoctrine()->getManager();

		$galeria = $em->getRepository('WebBundle:Galeria')->findBy(array('activo' => 1 ));

		$banner = $em->getRepository('WebBundle:Banner')->findBy(array('activo' => 1 ));

		return $this->render('WebBundle::galeria.html.twig', array(
			'session' 	=> $session,
			'galeria'	=> $galeria,
			'banner' 	=> $banner,
			'pagina'	=> 'galeria',
		));

	}
}