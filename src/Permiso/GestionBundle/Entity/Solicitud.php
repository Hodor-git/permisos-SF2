<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Solicitud 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="fecha_entrada", type="date")
     */
    private $fechaEntrada;
    
    /**
     * @ORM\Column(name="fecha_gestion", type="date")
     */
    private $fechaGestion;
    
    /**
     * @ORM\Column(name="finalizada", type="boolean")
     */
    private $finalizada;
    
    /**
     * @ORM\Column(name="denegada", type="boolean")
     */
    private $denegada;
    
    /**
     * @ORM\Column(name="observaciones", type="string", length=200)
     */
    private $observaciones;
    
    /**
     * @ORM\Column(name="empleado_id", type="int")
     */
    private $empleado;
}


