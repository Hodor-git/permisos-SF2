<?php

namespace Permiso\GestionBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Permiso\GestionBundle\Entity\Solicitud;

/**
 * @ORM\Entity
 * @ORM\Table(name="permiso")
 */
class Permiso extends Solicitud
{
    /**
     * @ORM\ManyToOne(targetEntity="TipoPermiso")
     * @ORM\JoinColumn(name="tipo_permiso_id", referencedColumnName="id")
     * @return integer
     */
    protected $tipoPermiso;

    /**
     * Set tipoPermiso
     *
     * @param Permiso\GestionBundle\Entity\TipoPermiso $tipoPermiso
     * @return Permiso
     */
    public function setTipoPermiso(\Permiso\GestionBundle\Entity\TipoPermiso $tipoPermiso = null)
    {
        $this->tipoPermiso = $tipoPermiso;
    
        return $this;
    }

    /**
     * Get tipoPermiso
     *
     * @return Permiso\GestionBundle\Entity\TipoPermiso 
     */
    public function getTipoPermiso()
    {
        return $this->tipoPermiso;
    }
    }
