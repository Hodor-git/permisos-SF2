<?php

namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="categoria")
 */
class Categoria implements RoleInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="nombre", type="string")
     */
    protected $nombre;
    
    /**
     * @ORM\Column(name="dias_vacaciones", type="integer")
     */
    protected $diasVacaciones;
    
    /**
     * @ORM\Column(name="nombre_rol", type="string")
     */
    protected $nombreRol;

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
     * @return Categoria
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
     * Set diasVacaciones
     *
     * @param integer $diasVacaciones
     * @return Categoria
     */
    public function setDiasVacaciones($diasVacaciones)
    {
        $this->diasVacaciones = $diasVacaciones;
    
        return $this;
    }

    /**
     * Get diasVacaciones
     *
     * @return integer 
     */
    public function getDiasVacaciones()
    {
        return $this->diasVacaciones;
    }

    /**
     * Set nombreRol
     *
     * @param string $nombreRol
     * @return Categoria
     */
    public function setNombreRol($nombreRol)
    {
        $this->nombreRol = $nombreRol;
    
        return $this;
    }

    /**
     * Get nombreRol
     *
     * @return string 
     */
    public function getNombreRol()
    {
        return $this->nombreRol;
    }
    
     public function getRole() 
    {
       return $this->getNombreRol(); 
    }
}