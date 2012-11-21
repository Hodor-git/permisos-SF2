<?php


namespace Permiso\GestionBundle\Entity;
 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Permiso\GestionBundle\Entity\Solicitud;

/**
 * @ORM\Table(name="vacaciones")
 * @ORM\Entity(repositoryClass="Permiso\GestionBundle\Repositorios\VacacionesRepository")
 */
class Vacaciones extends Solicitud
{
    /**
     * @ORM\Column(name="dias_pedidos", type="integer")
     * @Assert\NotBlank(message = "El valor no puede dejarse en blanco")
     * @Assert\Min(limit = "1", message = "El valor no puede ser inferior a 1")
     */
    protected $diasPedidos;

    /**
     * Set diasPedidos
     *
     * @param integer $diasPedidos
     * @return Vacaciones
     */
    public function setDiasPedidos($diasPedidos)
    {
        $this->diasPedidos = $diasPedidos;
    
        return $this;
    }

    /**
     * Get diasPedidos
     *
     * @return integer 
     */
    public function getDiasPedidos()
    {
        return $this->diasPedidos;
    }
}