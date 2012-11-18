<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Entity\TipoPermiso;
use Permiso\GestionBundle\Entity\Permiso;

class DefaultController extends Controller
{
    public function indexAction()
    {
        
        $vacaciones  = new Vacaciones;
        
        $hoy = new \DateTime("now");
        
        $vacaciones->setEmpleado(1);
        $vacaciones->setDiasPedidos(20);
        $vacaciones->setFechaEntrada($hoy);
        $vacaciones->setFechaGestion($hoy);
        $vacaciones->setFinalizada(true);
        $vacaciones->setDenegada(false);
        $vacaciones->setObservaciones('Probando observaciones en BDD');

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($vacaciones);
        $em->flush(); 
        
        return $this->render('PermisoGestionBundle:Default:index.html.twig', array());
    }
    
    public function permisoAction()
    {
        $tipoPermiso = new TipoPermiso();
        
        $hoy = new \DateTime("now");
        
        $tipoPermiso->setNombre('paternidad');
        $tipoPermiso->setDuracion(10);
        
        $permiso = new Permiso();
        
        $permiso->setEmpleado(2);
        $permiso->setFechaEntrada($hoy);
        $permiso->setFechaGestion($hoy);
        $permiso->setFinalizada(false);
        $permiso->setDenegada(false);
        $permiso->setObservaciones('probando las entidades de permiso');
        $permiso->setTipoPermiso($tipoPermiso);
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($tipoPermiso);
        $em->persist($permiso);
        
        $em->flush();
        
        return $this->render('PermisoGestionBundle:Default:index.html.twig', array());
    }
}
