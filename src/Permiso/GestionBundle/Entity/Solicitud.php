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
     * @ORM\Column(name="empleado_id", type="integer")
     */
    private $empleado;

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
     * Set fechaEntrada
     *
     * @param \DateTime $fechaEntrada
     * @return Solicitud
     */
    public function setFechaEntrada($fechaEntrada)
    {
        $this->fechaEntrada = $fechaEntrada;
    
        return $this;
    }

    /**
     * Get fechaEntrada
     *
     * @return \DateTime 
     */
    public function getFechaEntrada()
    {
        return $this->fechaEntrada;
    }

    /**
     * Set fechaGestion
     *
     * @param \DateTime $fechaGestion
     * @return Solicitud
     */
    public function setFechaGestion($fechaGestion)
    {
        $this->fechaGestion = $fechaGestion;
    
        return $this;
    }

    /**
     * Get fechaGestion
     *
     * @return \DateTime 
     */
    public function getFechaGestion()
    {
        return $this->fechaGestion;
    }

    /**
     * Set finalizada
     *
     * @param boolean $finalizada
     * @return Solicitud
     */
    public function setFinalizada($finalizada)
    {
        $this->finalizada = $finalizada;
    
        return $this;
    }

    /**
     * Get finalizada
     *
     * @return boolean 
     */
    public function getFinalizada()
    {
        return $this->finalizada;
    }

    /**
     * Set denegada
     *
     * @param boolean $denegada
     * @return Solicitud
     */
    public function setDenegada($denegada)
    {
        $this->denegada = $denegada;
    
        return $this;
    }

    /**
     * Get denegada
     *
     * @return boolean 
     */
    public function getDenegada()
    {
        return $this->denegada;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Solicitud
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    
        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set empleado
     *
     * @param integer $empleado
     * @return Solicitud
     */
    public function setEmpleado($empleado)
    {
        $this->empleado = $empleado;
    
        return $this;
    }

    /**
     * Get empleado
     *
     * @return integer 
     */
    public function getEmpleado()
    {
        return $this->empleado;
    }
}