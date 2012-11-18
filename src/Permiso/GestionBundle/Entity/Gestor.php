<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Permiso\GestionBundle\Entity\Empleado;

/**
 * @ORM\Entity
 * @ORM\Table(name="gestor")
 */
class Gestor extends Empleado
{
    //put your code here
}