<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
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
    private $tipoPermiso;
}


