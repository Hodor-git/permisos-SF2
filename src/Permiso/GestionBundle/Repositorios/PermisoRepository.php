<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class PermisoRepository extends EntityRepository
{
//    /**
//     * Recibe el objeto Permiso desde el controlador y lo guarda
//     * en la persistencia.
//     * 
//     * @param type $permiso (objeto Permiso)
//     * @param type $usuarioEnSesion (objeto Usuario en sesión)
//     */
//    public function guardarPermiso($permiso, $usuarioEnSesion)
//    {
//        //Fecha de hoy
//        $hoy = new \DateTime("now");
//        
//        //Se rellena el objeto Permiso con el resto de
//        //parámetros necesarios.
//        $permiso->setEmpleado($usuarioEnSesion);
//        $permiso->setFechaEntrada($hoy);
//        $permiso->setFinalizada(false);
//        $permiso->setDenegada(false);
//        
//        //Obtiene el EntityManager
//        $em = $this->getEntityManager();
//        
//        //Persiste la entidad en la BDD
//        $em->persist($permiso);
//        $em->flush();
//    }
    
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
     * Método para listar los permisos gestionados pendientes de aprobación.
     * Es decir, aquellas solicitudes pertenecientes a los empleados a cargo de 
     * determinado gestor.
     * 
     * @param integer $gestorID
     * @return array listado
     */
    public function permisosPendientesGestionar($gestorID)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query->select('p')
        ->from('Permiso\GestionBundle\Entity\Permiso', 'p')
        ->innerJoin('p.empleado', 'e')
        ->where('p.finalizada = ?1 AND e.gestor = ?2')
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


