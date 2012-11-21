<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class VacacionesRepository extends EntityRepository
{
    /**
     * Recibe el objeto Vacaciones desde el controlador y lo guarda
     * en la persistencia.
     * 
     * @param type $permiso (objeto Vacaciones)
     * @param type $usuarioEnSesion (objeto Usuario en sesión)
     */
    public function guardarVacaciones($vacaciones, $usuarioEnSesion)
    {
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        //Se rellena el objeto Vacaciones con el resto de
        //parámetros necesarios.
        $vacaciones->setEmpleado($usuarioEnSesion);
        $vacaciones->setFechaEntrada($hoy);
        $vacaciones->setFinalizada(false);
        $vacaciones->setDenegada(false);
        
        //Obtiene el EntityManager
        $em = $this->getEntityManager();
        
        //Persiste la entidad en la BDD
        $em->persist($vacaciones);
        $em->flush();
    }    
}

