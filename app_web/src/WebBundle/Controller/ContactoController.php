<?php
namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactoController extends Controller
{
	
	public function contactoAction(Request $request)
	{
		$session1 = $request->getSession();
        $session  = ($session1->get('admin'))? true: false;
        $em      = $this->getDoctrine()->getManager();

        $banner = $em->getRepository('WebBundle:Banner')->findBy(array('activo' => 1 ));

		return $this->render('WebBundle::contacto.html.twig', array(
			'session' 	=> $session,
            'banner'    => $banner,
			'pagina'	=> 'contacto'
		));
	}

	public function enviarContactoAction(Request $request)
    {
        $result = false;
        $datos  = array();
        $datos['nombre']    = ($request->get('nombre', false))? $request->get('nombre'): 0;
        $datos['correo']    = ($request->get('correo', false))? $request->get('correo'): 0;
        $datos['telefono']  = ($request->get('telefono', false))? $request->get('telefono'): 0;
        $datos['mensaje']   = stripcslashes(nl2br(htmlentities($request->get('mensaje'))));
        $datos['to']        = 'jonathanpadilla09@outlook.com';

        if($this->enviarMail($datos))
        {
            $result = true;
        }        

        echo json_encode(array('result' => $result));
        exit;
    }

    public function enviarMail($arr = false)
    {
        $return = false;
        if(is_array($arr))
        {
            $headers = "From: " . $arr['correo'] . "\r\n";
            $headers .= "Reply-To: ". $arr['correo']. "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $contenido = $this->renderView('WebBundle:Default:plantilla_email.html.twig',array('datos' => $arr));

            // echo $contenido; exit;

            if(mail($arr['to'], 'www.mitortaangelina.cl - '.$arr['nombre'], $contenido, $headers))
            {
                $return = true;
            }


        }

        return $return;
    }
}