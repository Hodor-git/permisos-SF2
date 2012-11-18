<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Example taken from the manual.
 * @Entity
 * Define Class Table Inheritance as the mapping strategy for this whole hierarchy:
 * @InheritanceType("JOINED")
 * Define the discriminator column:
 * @DiscriminatorColumn(name="discriminador", type="string")
 * Define a map of keys and values (class names):
 * @DiscriminatorMap({"empleado" = "Empleado", "gestor" = "Gestor"})
 */
class Empleado 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(name="username", type="string")
     */
    private $username;
    
    /**
     * @ORM\Column(name="password", type="string")
     */
    private $password;
    
    /**
     * @ORM\Column(name="salt", type="string", nullable=TRUE)
     */
    private $salt;
    
    /**
     * @ORM\Column(name="email", type="string")
     */
    private $email;
    
    /**
     * @ORM\ManyToOne(targetEntity="Categoria")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     * @return integer
     */
    private $categoria;
    
    /**
     * @ORM\ManyToOne(targetEntity="Gestor")
     * @ORM\JoinColumn(name="gestor_id", referencedColumnName="id", nullable=TRUE)
     * @return integer
     */
    private $gestor;
    
    
}


