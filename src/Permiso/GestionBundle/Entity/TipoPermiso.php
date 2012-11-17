<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @ORM\Column(name="duracion", type="int")
     */
    private $duracion;
    
}


