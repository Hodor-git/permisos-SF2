<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Form\VacacionesType;


class SolicitudController extends Controller
{
    
    /*
     * Entity Manager
     */
    private $em;

    /*
     * Repositorio (DAO)
     */
    private $repositorio;

    public function getEntityManager()
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        return $this->em;
    }
    
    /**
     * Obtiene el repositorio de la clase $nombre
     * @param type $nombre (Nombre de la clase)
     * @return type
     */
    public function getRepositorio($nombre)
    {
        $this->repositorio = $this->getEntityManager()->getRepository('PermisoGestionBundle:'.$nombre);

        return $this->repositorio;
    }
    
    public function indexAction()
    {
       
    }
    
    public function solicitarVacacionesAction()
    {      
        //Fecha de hoy
        $hoy = new \DateTime("now");
        
        //-- Obtenemos el request que contendrá los datos
        $request = $this->getRequest();
        
        //---Obtenemos el usuario de la sesión (objeto)
        $usuarioEnSesion = $this->getUser();
        
        // Nueva entidad de tipo Vacaciones
        $vacaciones = new Vacaciones();
        // Nuevo formulario al cual le pasamos los campos asociados
        // a la entidad Vacaciones
        $form = $this->createForm(new VacacionesType(), $vacaciones);
        
        /**
         * Si el request viene de un POST
         */
        if($request->getMethod() == 'POST')
        {
            /*
             * Ata los parámetros recibidos desde el POST al formulario
             */
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $vacaciones->setEmpleado($usuarioEnSesion);
                $vacaciones->setFechaEntrada($hoy);
                $vacaciones->setFinalizada(false);
                $vacaciones->setDenegada(false);
                
                $this->getRepositorio('Vacaciones')->guardarVacaciones($vacaciones);
                
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', array('form' => $form->createView()));
    }
   
}


