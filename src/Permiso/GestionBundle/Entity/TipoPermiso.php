<?php

namespace Permiso\GestionBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Permiso\GestionBundle\Entity\Solicitud;

/**
 * @ORM\Entity
 * @ORM\Table(name="tipo_permiso")
 */
class TipoPermiso 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="nombre", type="string")
     */
    private $nombre;
    
    /**
     * @ORM\Column(name="duracion", type="integer")
     */
    private $duracion;
    

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
     * Set nombre
     *
     * @param string $nombre
     * @return TipoPermiso
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    
        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set duracion
     *
     * @param integer $duracion
     * @return TipoPermiso
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    
        return $this;
    }

    /**
     * Get duracion
     *
     * @return integer 
     */
    public function getDuracion()
    {
        return $this->duracion;
    }
}