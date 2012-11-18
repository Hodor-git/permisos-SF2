<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Entity\TipoPermiso;
use Permiso\GestionBundle\Entity\Permiso;
use Permiso\GestionBundle\Entity\Gestor;
use Permiso\GestionBundle\Entity\Categoria;
use Permiso\GestionBundle\Entity\Empleado;

class DefaultController extends Controller
{
    public function indexAction()
    {
        /*
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
        $em->flush();*/
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $categoria = new Categoria();
        
        $categoria->setNombre('empleado');
        $categoria->setDiasVacaciones(20);
        
        $gestor = $em->getRepository('PermisoGestionBundle:Gestor');
        
        $pepito = $gestor->findBy(array('username' => 'pepe'));
        
        
        $manolo = new Empleado();
        
        $manolo->setUsername('manolo');
        $manolo->setPassword('gafotas');
        $manolo->setSalt('asd312asdas23');
        $manolo->setEmail('manolo@lolailo.com');
        $manolo->setCategoria($categoria);
        $manolo->setGestor($pepito[0]);
        
        $em->persist($categoria);
        $em->persist($manolo);
        
        $em->flush();
        
        return $this->render('PermisoGestionBundle:Default:index.html.twig'); /*, array('gestor' => var_dump($pepito)*/
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
