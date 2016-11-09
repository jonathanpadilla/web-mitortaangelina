<?php
namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WebBundle\Entity\Pasos;

class ArmaController extends Controller
{
	
	public function armaAction(Request $request)
	{
		$session1 = $request->getSession();
        $session  = ($session1->get('admin'))? true: false;
		$em      = $this->getDoctrine()->getManager();

		$banner = $em->getRepository('WebBundle:Banner')->findBy(array('activo' => 1 ));

		$pasos = $em->getRepository('WebBundle:Pasos')->findAll();

		return $this->render('WebBundle::arma.html.twig', array(
			'session' 	=> $session,
			'banner'	=> $banner,
			'pasos'		=> $pasos,
			'pagina'	=> 'arma'
		));
	}

	public function enviarPedidoAction(Request $request)
	{
		$result 	= false;
		$em 		= $this->getDoctrine()->getManager();
		$nombre 	= $request->get('txt_nombre');
		$correo 	= $request->get('txt_correo');
		$telefono 	= $request->get('txt_telefono');

		$evento 	= $em->getRepository('WebBundle:Pasos')->findOneBy(array('id' => $request->get('select_evento') ));
		$relleno 	= $em->getRepository('WebBundle:Pasos')->findOneBy(array('id' => $request->get('select_relleno') ));
		$sabor 		= $em->getRepository('WebBundle:Pasos')->findOneBy(array('id' => $request->get('select_sabor') ));
		$cobertura	= $em->getRepository('WebBundle:Pasos')->findOneBy(array('id' => $request->get('select_cobertura') ));

		$mensaje = '';
		$mensaje .= '<h3>Pedido</h3>';
		$mensaje .= '<table>';
		$mensaje .= '<tr><td>Torta para '.$request->get('txt_cantidad').' personas</td></tr>';
		$mensaje .= '<tr><td>Evento '.$evento->getNombre().'</td></tr>';
		$mensaje .= '<tr><td>Relleno '.$relleno->getNombre().'</td></tr>';
		$mensaje .= '<tr><td>Sabor '.$sabor->getNombre().'</td></tr>';
		$mensaje .= '<tr><td>Cobertura '.$cobertura->getNombre().'</td></tr>';
		$mensaje .= '<tr><td>'.$request->get('txt_observacion').'</td></tr>';
		$mensaje .= '</table>';
		$mensaje .= '<br>';
		$mensaje .= stripcslashes(nl2br(htmlentities($request->get('txt_comentario'))));

		$datos  = array();
        $datos['nombre']    = $nombre;
        $datos['correo']    = $correo;
        $datos['telefono']  = $telefono;
        $datos['mensaje']   = $mensaje;
        $datos['to']        = 'jonathanpadilla09@outlook.com';

        if($this->enviarMail($datos))
        {
            $result = true;
        } 

		echo json_encode(array('result' => $result));
		exit;
	}

	public function guardarPasoAction(Request $request)
	{
		$result = false;
		$tipo 	= $request->get('tipo');
		$nombre = $request->get('nombre');
		$em 	= $this->getDoctrine()->getManager();

		if($nombre != '')
		{
			$pasos = new Pasos();
			$pasos->setNombre($nombre);
			$pasos->setTipo($tipo);
			$em->persist($pasos);
			$em->flush();

			$result = true;
		}

		echo json_encode(array('result' => $result));
		exit;
	}

	public function eliminarPasoAction(Request $request)
	{
		$result = false;
		$id 	= $request->get('id');
		$em 	= $this->getDoctrine()->getManager();

		if($registro = $em->getRepository('WebBundle:Pasos')->findOneBy(array('id' => $id )))
		{
			$em->remove($registro);
			$em->flush();

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