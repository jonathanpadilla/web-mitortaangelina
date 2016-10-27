<?php

namespace WebBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seccion
 *
 * @ORM\Table(name="seccion")
 * @ORM\Entity
 */
class Seccion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=100, nullable=true)
     */
    private $imagen;

    /**
     * @var string
     *
     * @ORM\Column(name="texto1", type="text", length=65535, nullable=true)
     */
    private $texto1;

    /**
     * @var string
     *
     * @ORM\Column(name="texto2", type="text", length=65535, nullable=true)
     */
    private $texto2;

    /**
     * @var string
     *
     * @ORM\Column(name="texto3", type="text", length=65535, nullable=true)
     */
    private $texto3;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", length=65535, nullable=true)
     */
    private $comentario;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set imagen
     *
     * @param string $imagen
     * @return Seccion
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string 
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    /**
     * Set texto1
     *
     * @param string $texto1
     * @return Seccion
     */
    public function setTexto1($texto1)
    {
        $this->texto1 = $texto1;

        return $this;
    }

    /**
     * Get texto1
     *
     * @return string 
     */
    public function getTexto1()
    {
        return $this->texto1;
    }

    /**
     * Set texto2
     *
     * @param string $texto2
     * @return Seccion
     */
    public function setTexto2($texto2)
    {
        $this->texto2 = $texto2;

        return $this;
    }

    /**
     * Get texto2
     *
     * @return string 
     */
    public function getTexto2()
    {
        return $this->texto2;
    }

    /**
     * Set texto3
     *
     * @param string $texto3
     * @return Seccion
     */
    public function setTexto3($texto3)
    {
        $this->texto3 = $texto3;

        return $this;
    }

    /**
     * Get texto3
     *
     * @return string 
     */
    public function getTexto3()
    {
        return $this->texto3;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Seccion
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }
}
