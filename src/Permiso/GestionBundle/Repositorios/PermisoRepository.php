<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class PermisoRepository extends EntityRepository
{
    /**
     * Recibe el objeto Permiso desde el controlador y lo guarda
     * en la persistencia.
     * 
     * @param type $permiso (objeto Permiso)
     * @param type $usuarioEnSesion (objeto Usuario en sesión)
     */
    public function guardarPermiso($permiso, $usuarioEnSesion)
    {
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        //Se rellena el objeto Permiso con el resto de
        //parámetros necesarios.
        $permiso->setEmpleado($usuarioEnSesion);
        $permiso->setFechaEntrada($hoy);
        $permiso->setFinalizada(false);
        $permiso->setDenegada(false);
        
        //Obtiene el EntityManager
        $em = $this->getEntityManager();
        
        //Persiste la entidad en la BDD
        $em->persist($permiso);
        $em->flush();
    }
    
    public function borrarSolicitud($solicitud)
    {
        $em = $this->getEntityManager();
        
        $em->remove($solicitud);
        $em->flush();
    }
}


