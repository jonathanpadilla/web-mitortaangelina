<?php
namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends Controller
{
	
	public function categoriaAction(Request $request)
	{
		$session1 = $request->getSession();
        $session  = ($session1->get('admin'))? true: false;
		$em      = $this->getDoctrine()->getManager();

		$banner = $em->getRepository('WebBundle:Banner')->findBy(array('activo' => 1 ));

		$categoria = $em->getRepository('WebBundle:Categoria')->findAll();

		return $this->render('WebBundle::categoria.html.twig', array(
			'session' 	=> $session,
			'banner'	=> $banner,
			'categoria' => $categoria,
			'pagina'	=> 'categoria'
		));
	}
}