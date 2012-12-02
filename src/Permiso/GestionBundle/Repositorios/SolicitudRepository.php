<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class SolicitudRepository extends EntityRepository
{
    /**
     * Recibe la solicitud desde el controlador y lo guarda
     * en la persistencia.
     * 
     * @param type $solicitud (objeto Solicitud)
     * @param type $usuarioEnSesion (objeto Usuario en sesión)
     */
    public function guardarSolicitud($solicitud, $usuarioEnSesion)
    {
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        //Se rellena el objeto Vacaciones con el resto de
        //parámetros necesarios.
        $solicitud->setEmpleado($usuarioEnSesion);
        $solicitud->setFechaEntrada($hoy);
        $solicitud->setFinalizada(false);
        $solicitud->setDenegada(false);
        
        //Obtiene el EntityManager
        $em = $this->getEntityManager();
        
        //Persiste la entidad en la BDD
        $em->persist($solicitud);
        $em->flush();
    }
    
    
    /**
     * Mediante este método se borra una solicitud 
     * de la BDD
     * @param type $solicitud
     */
    public function borrarSolicitud($solicitud) 
    {
        $em = $this->getEntityManager();
        
        $em->remove($solicitud);
        $em->flush();
    }
}


