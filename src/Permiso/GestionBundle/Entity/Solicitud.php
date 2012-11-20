<?php

namespace Permiso\GestionBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class Solicitud 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(name="fecha_entrada", type="date")
     */
    protected $fechaEntrada;
    
    /**
     * @ORM\Column(name="fecha_inicio", type="date")
     */
    protected $fechaInicio;
    
    /**
     * @ORM\Column(name="fecha_gestion", type="date")
     */
    protected $fechaGestion;
    
    /**
     * @ORM\Column(name="finalizada", type="boolean")
     */
    protected $finalizada;
    
    /**
     * @ORM\Column(name="denegada", type="boolean")
     */
    protected $denegada;
    
    /**
     * @ORM\Column(name="observaciones", type="string", length=200)
     * @Assert\MaxLength(limit = "200", message = "Máximo 200 caracteres")
     */
    protected $observaciones;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empleado")
     * @ORM\JoinColumn(name="empleado_id", referencedColumnName="id")
     * @return integer
     */
    protected $empleado;

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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return Solicitud
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;
    
        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
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
     * @param Permiso\GestionBundle\Entity\Empleado $empleado
     * @return Solicitud
     */
    public function setEmpleado(\Permiso\GestionBundle\Entity\Empleado $empleado = null)
    {
        $this->empleado = $empleado;
    
        return $this;
    }

    /**
     * Get empleado
     *
     * @return Permiso\GestionBundle\Entity\Empleado 
     */
    public function getEmpleado()
    {
        return $this->categoria;
    }
    
}