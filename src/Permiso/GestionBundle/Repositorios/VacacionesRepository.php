<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class VacacionesRepository extends EntityRepository
{
//    /**
//     * Recibe el objeto Vacaciones desde el controlador y lo guarda
//     * en la persistencia.
//     * 
//     * @param type $permiso (objeto Vacaciones)
//     * @param type $usuarioEnSesion (objeto Usuario en sesión)
//     */
//    public function guardarVacaciones($vacaciones, $usuarioEnSesion)
//    {
//        //Fecha de hoy
//        $hoy = new \DateTime("now");
//        
//        //Se rellena el objeto Vacaciones con el resto de
//        //parámetros necesarios.
//        $vacaciones->setEmpleado($usuarioEnSesion);
//        $vacaciones->setFechaEntrada($hoy);
//        $vacaciones->setFinalizada(false);
//        $vacaciones->setDenegada(false);
//        
//        //Obtiene el EntityManager
//        $em = $this->getEntityManager();
//        
//        //Persiste la entidad en la BDD
//        $em->persist($vacaciones);
//        $em->flush();
//    }
//    
//    /**
//     * Mediante este método se borra una solicitud 
//     * de la BDD
//     * @param type $solicitud
//     */
//    public function borrarSolicitud($solicitud) 
//    {
//        $em = $this->getEntityManager();
//        
//        $em->remove($solicitud);
//        $em->flush();
//    }
    
    /**
     * Método para listar las vacaciones gestionadas pendientes de aprobación.
     * Es decir, aquellas solicitudes pertenecientes a los empleados a cargo de 
     * determinado gestor.
     * 
     * @param integer $gestorID
     * @return array listado
     */
    public function vacacionesPendientesGestionar($gestorID)
    {     
//       $query = $this->createQueryBuilder('v');
//       $query->add('select', 'v')
//                ->add('from', '\Permiso\GestionBundle\Entity\Vacaciones v, \Permiso\GestionBundle\Entity\Empleado e, \Permiso\GestionBundle\Entity\Gestor g')
//                ->add('where', "v.finalizada = ?1 AND v.empleado = e.id AND e.gestor = ?2")
//                 ->setParameters(array (1 => false, 2 => 1));
      
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query->select('v')
        ->from('Permiso\GestionBundle\Entity\Vacaciones', 'v')
        ->innerJoin('v.empleado', 'e')
        ->where('v.finalizada = ?1 AND e.gestor = ?2')
        ->setParameters(array (1 => false, 2 => $gestorID));
        
        $resultado = $query->getQuery()->getResult();
      
        return $resultado;       
    }
    
    /**
     * método que permite aceptar/rechazar una solicitud de un empleado
     * por parte del gestor correspondiente.
     * @param type $denegada (true: solicitud rechazada / false: solicitud aceptada)
     * @param type $resolucion (texto donde explica brevemente la decisión)
     * @param type $solicitud (objeto a persistir en la BDD)
     */
    public function gestionarSolicitudRepositorio($denegada, $resolucion, $solicitud)
    {
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        $em = $this->getEntityManager();
        
        $solicitud->setDenegada($denegada);
        $solicitud->setFinalizada(TRUE);
        $solicitud->setResolucion($resolucion);
        $solicitud->setFechaGestion($hoy);
        
        $em->persist($solicitud);
        $em->flush();
    }
}

