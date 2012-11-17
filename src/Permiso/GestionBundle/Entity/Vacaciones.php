<?php


namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Permiso\GestionBundle\Entity\Solicitud;

/**
 * @ORM\Entity
 * @ORM\Table(name="vacaciones")
 */
class Vacaciones extends Solicitud
{
    /**
     * @ORM\Column(name="dias_pedidos", type="int")
     */
    private $diasPedidos;
}


