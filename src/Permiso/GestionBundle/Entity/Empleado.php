<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Example taken from the manual.
 * @ORM\Entity
 * Define Class Table Inheritance as the mapping strategy for this whole hierarchy:
 * @ORM\InheritanceType("JOINED")
 * Define the discriminator column:
 * @ORM\DiscriminatorColumn(name="discriminador", type="string")
 * Define a map of keys and values (class names):
 * @ORM\DiscriminatorMap({"empleado" = "Empleado", "gestor" = "Gestor"})
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
     * Set username
     *
     * @param string $username
     * @return Empleado
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Empleado
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Empleado
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Empleado
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set categoria
     *
     * @param Permiso\GestionBundle\Entity\Categoria $categoria
     * @return Empleado
     */
    public function setCategoria(\Permiso\GestionBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;
    
        return $this;
    }

    /**
     * Get categoria
     *
     * @return Permiso\GestionBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * Set gestor
     *
     * @param Permiso\GestionBundle\Entity\Gestor $gestor
     * @return Empleado
     */
    public function setGestor(\Permiso\GestionBundle\Entity\Gestor $gestor = null)
    {
        $this->gestor = $gestor;
    
        return $this;
    }

    /**
     * Get gestor
     *
     * @return Permiso\GestionBundle\Entity\Gestor 
     */
    public function getGestor()
    {
        return $this->gestor;
    }
}