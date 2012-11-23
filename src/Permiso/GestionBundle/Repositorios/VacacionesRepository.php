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
    
    public function borrarSolicitud($solicitud) 
    {
        $em = $this->getEntityManager();
        
        $em->remove($solicitud);
        $em->flush();
    }
    
    public function vacacionesPendientesGestionar($gestor)
    {
//      $query = $this->createQueryBuilder('v')
//              ->setParameter('finalizada', false);
//      
//      $resultado = $query->getQuery()->getResult(); AND e.id = ?2" , 2=> 3
      
       $query = $this->createQueryBuilder('v');
       $query->add('select', 'v')
                ->add('from', '\Permiso\GestionBundle\Entity\Vacaciones v, \Permiso\GestionBundle\Entity\Empleado e, \Permiso\GestionBundle\Entity\Gestor g')
                ->add('where', "v.finalizada = ?1 AND v.empleado = e.id AND e.gestor = g.id") 
                ->setParameters(array (1=> false));

        //echo $qb->getDql();
        $resultado = $query->getQuery()->getResult();
      
        return $resultado;
    }
}

