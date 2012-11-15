<?php
 
namespace Permiso\AuthBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
 
    /**
     * @ORM\Column(name="usuario", type="string", length=255)
     */
    protected $usuario;
 
    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;
 
    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;
 
    /**
     * @ORM\ManyToMany(targetEntity="Rol")
     * @ORM\JoinTable(name="usuario_rol",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $roles;

    public function getSalt() 
    {
        return $this->salt;
    }

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set usuario
     *
     * @param string $usuario
     * @return Usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    
        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function getUsername() 
    {
        return $this->usuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    
        return $this;
    }

    /**
     * Add roles
     *
     * @param Permiso\AuthBundle\Entity\Rol $roles
     * @return Usuario
     */
    public function addRole(\Permiso\AuthBundle\Entity\Rol $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param Permiso\AuthBundle\Entity\Rol $roles
     */
    public function removeRole(\Permiso\AuthBundle\Entity\Rol $roles)
    {
        $this->roles->removeElement($roles);
    }

    public function getPassword() 
    {
        return $this->password;
    }
    
    public function getRoles() 
    {
        //return $this->roles->toArray();
        $roles = array();
        foreach ($this->roles as $role) {
        $roles[] = $role->getRole();
        }

        return $roles;
        }
    
    public function eraseCredentials() {
        
    }
}