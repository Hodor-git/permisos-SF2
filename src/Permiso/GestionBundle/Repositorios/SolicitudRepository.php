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
    
    /**
     * Método que permite aceptar/rechazar una solicitud de un empleado
     * por parte del gestor correspondiente.
     * 
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
    
    /**
     * Método para listar las solicitudes gestionadas pendientes de aprobación.
     * Es decir, aquellas solicitudes pertenecientes a los empleados a cargo de 
     * determinado gestor que no han sido todavía valoradas por éste.
     * 
     * @param integer $gestorID
     * @param string $tipo (Ejemplo de tipo de solicitud: "\Permiso", "\Vacaciones")
     * @return array listado
     */
    public function solicitudPendienteGestionar($gestorID, $tipo)
    {
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query->select('p')
        ->from('Permiso\GestionBundle\Entity'.$tipo, 'p')
        ->innerJoin('p.empleado', 'e')
        ->where('p.finalizada = ?1 AND e.gestor = ?2')
        ->setParameters(array (1 => false, 2 => $gestorID));
        
        $resultado = $query->getQuery()->getResult();
      
        return $resultado;
    }
    
    /**
     * Devuelve los días de vacaciones consumidos por el empleado
     * @param type $empleado
     * @return type
     */
    public function diasVacacionesConsumidosPorEmpleado($empleado)
    {
        
        $query = $this->getEntityManager()->createQueryBuilder();
        
        $query->select('SUM(v.diasPedidos)')
                ->from('Permiso\GestionBundle\Entity\Vacaciones', 'v')
                ->where('v.empleado = ?1 AND v.denegada = ?2')
                ->setParameters(array (1 => $empleado, 2 => FALSE));
        
        $resultado = $query->getQuery()->getResult();
        
        return $resultado[0][1];
    }
}


