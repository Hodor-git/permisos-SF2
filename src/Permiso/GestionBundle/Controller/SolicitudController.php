<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Form\VacacionesType;


class SolicitudController extends Controller
{
    public function indexAction()
    {
        
    }
    
    public function solicitarVacacionesAction()
    {
        // Entity Manager
        $em = $this->getDoctrine()->getEntityManager();
        
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        //-- Obtenemos el request que contendrá los datos
        $request = $this->getRequest();
        
        $usuarioEnSesion = $this->getUser();
        //$empleadoRepositorio = $em->getRepository('PermisoGestionBundle:Empleado');
        //$empleado = $empleadoRepositorio->findBy(array('username' => $usuarioEnSesion));
        
        $vacaciones = new Vacaciones();
        $form = $this->createForm(new VacacionesType(), $vacaciones);
        
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $vacaciones->setEmpleado($usuarioEnSesion);
                $vacaciones->setFechaEntrada($hoy);
                $vacaciones->setFinalizada(false);
                $vacaciones->setDenegada(false);
                
                
                $em->persist($vacaciones);
                $em->flush();
                
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', array('form' => $form->createView(),));
    }
   
}


