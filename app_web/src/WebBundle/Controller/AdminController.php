<?php

namespace WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WebBundle\Entity\Galeria;
use WebBundle\Entity\Banner;
use WebBundle\Entity\Categoria;

class AdminController extends Controller
{
	public function guardarTextoAction(Request $request)
	{
		// variables
    	$result = false;
    	$id 	= ($request->get('id', false))		?$request->get('id')	:null;
    	$campo 	= ($request->get('campo', false))	?$request->get('campo')	:null;
    	$texto 	= ($request->get('texto', false))	?$request->get('texto')	:null;
    	$em 	= $this->getDoctrine()->getManager();

    	// actualizar texto
    	if( is_numeric($id) && $seccion = $em->getRepository('WebBundle:Seccion')->findOneBy(array('id' => $id )) )
    	{
    		switch($campo)
    		{
    			case 1: $seccion->setTexto1($texto);break;
    			case 2: $seccion->setTexto2($texto);break;
    			case 3: $seccion->setTexto3($texto);break;
    		}

    		$em->persist($seccion);
    		$em->flush();

    		$result = true;
    	}

    	echo json_encode(array('result' => $result));
    	exit;
	}

    public function guardarImagenGaleriaAction(Request $request)
    {
        $result = false;
        $foto   = ($request->files->get('file_foto_galeria', false))? $request->files->get('file_foto_galeria', false): null;
        $em     = $this->getDoctrine()->getManager();

        if($img = $this->subirImagen($foto))
        {
            $galeria = new Galeria();
            $galeria->setImg($img);
            $galeria->setActivo(1);
            $em->persist($galeria);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }

    public function guardarImagenBannerAction(Request $request)
    {
        $result = false;
        $foto   = ($request->files->get('file_imagen_banner', false))? $request->files->get('file_imagen_banner', false): null;
        $em     = $this->getDoctrine()->getManager();

        if($img = $this->subirImagen($foto))
        {
            $banner = new Banner();
            $banner->setImg($img);
            $banner->setActivo(1);
            $em->persist($banner);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }

    private function subirImagen($foto)
    {
        $result = false;

        if($foto)
        {
            $obj = array(
                'filesize'      => $foto->getClientSize(),
                'filetype'      => $foto->getClientMimeType(),
                'fileextension' => $foto->getClientOriginalExtension(),
                'filenewname'   => uniqid().".".$foto->getClientOriginalExtension(),
                'filenewpath'   => __DIR__.'/../../../../img/uploads'
            );

            if($obj['filesize'] <= 5242880 && ($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg') )
            {
                $foto->move($obj['filenewpath'], $obj['filenewname']);

                $result = 'img/uploads/'.$obj['filenewname'];
            }

        }

        return $result;
    }

    public function eliminarImagenGaleriaAction(Request $request)
    {
        $result = false;
        $id     = ($request->get('id', false))? $request->get('id'): 0;
        $em     = $this->getDoctrine()->getManager();

        if($galeria = $em->getRepository('WebBundle:Galeria')->findOneBy(array('id' => $id )))
        {
            $galeria->setActivo(0);
            $em->persist($galeria);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }

    public function eliminarImagenBannerAction(Request $request)
    {
        $result = false;
        $id     = ($request->get('id', false))? $request->get('id'): 0;
        $em     = $this->getDoctrine()->getManager();

        if($banner = $em->getRepository('WebBundle:Banner')->findOneBy(array('id' => $id )))
        {
            $banner->setActivo(0);
            $em->persist($banner);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }

    public function guardarImagenCategoriaAction(Request $request)
    {
        $result     = false;
        $foto       = ($request->files->get('foto', false))? $request->files->get('foto', false): null;
        $categoria  = $request->get('select_categoria', false);
        $em         = $this->getDoctrine()->getManager();

        if($img = $this->subirImagen($foto))
        {
            $cat = new Categoria();
            $cat->setFoto($img);
            $cat->setCategoria($categoria);
            $em->persist($cat);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }

    public function eliminarImagenCategoriaAction(Request $request)
    {
        $result = false;
        $id     = ($request->get('id', false))? $request->get('id'): 0;
        $em     = $this->getDoctrine()->getManager();

        if($categoria = $em->getRepository('WebBundle:Categoria')->findOneBy(array('id' => $id )))
        {
            $em->remove($categoria);
            $em->flush();

            $result = true;
        }

        echo json_encode(array('result' => $result));
        exit;
    }
}