<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Form\VacacionesType;
use Permiso\GestionBundle\Entity\Permiso;
use Permiso\GestionBundle\Form\PermisoType;


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
     * Obtiene el repositorio (DAO) de la clase $nombre
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
       //Código.....
    }
    
    public function solicitarVacacionesAction()
    {      
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
             * Incorpora los parámetros recibidos desde el POST al objeto formulario
             */
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                //Obtiene el repositorio de la entidad y guarda ésta en la persistencia
                $this->getRepositorio('Vacaciones')->guardarVacaciones($vacaciones, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido creada y guardada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', 
                array('form' => $form->createView(), 'valorSubmit' => 'Enviar', 'editar' => false));
    }
    
    public function editarVacacionesAction($id)
    {
        $vacaciones = $this->getRepositorio('Vacaciones')->findOneBy(array('id' => $id));
        
        //---Obtenemos el usuario de la sesión (objeto)
        $usuarioEnSesion = $this->getUser();
        
        $form = $this->createForm(new VacacionesType, $vacaciones);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $this->getRepositorio('Vacaciones')->guardarVacaciones($vacaciones, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido editada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', 
                array('form' => $form->createView(), 'valorSubmit' => 'Editar', 'editar' => true, 'id' => $id));
    }


    public function solicitarPermisoAction()
    {   
        //-- Obtenemos el request que contendrá los datos
        $request = $this->getRequest();
        
        //---Obtenemos el usuario de la sesión (objeto)
        $usuarioEnSesion = $this->getUser();
        
        // Nueva entidad de tipo Permiso
        $permiso = new Permiso();
        
        // Nuevo formulario al cual le pasamos los campos asociados
        // a la entidad Permiso
        $form = $this->createForm(new PermisoType(), $permiso);
        
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
                //Obtiene el repositorio de la entidad y guarda ésta en la persistencia
                $this->getRepositorio('Permiso')->guardarPermiso($permiso, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido creada y guardada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:permisoForm.html.twig', 
                array('form' => $form->createView(),'valorSubmit' => 'Enviar', 'editar' => false));
    }
    
    public function editarPermisoAction($id)
    {
        $permiso = $this->getRepositorio('Permiso')->findOneBy(array('id' => $id));
        
        //---Obtenemos el usuario de la sesión (objeto)
        $usuarioEnSesion = $this->getUser();
        
        $form = $this->createForm(new PermisoType, $permiso);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $this->getRepositorio('Permiso')->guardarPermiso($permiso, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido editada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:permisoForm.html.twig', 
                array('form' => $form->createView(), 'valorSubmit' => 'Editar', 'editar' => true, 'id' => $id));
    }
    
    public function mostrarSolicitudAction($tipo, $id)
    {
        $solicitud = $this->getRepositorio($tipo)->findOneBy(array('id' => $id));
        
        if(!$solicitud)
        {
            throw $this->createNotFoundException('No es posible mostrar la solicitud. Por favor, inténtelo de nuevo.');
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:mostrarSolicitud.html.twig', array('solicitud' => $solicitud, 'tipo' => $tipo));
    }
    
    public function borrarSolicitudAction($tipo, $id)
    {
        $repositorio = $this->getRepositorio($tipo);
        
        if (!$repositorio) 
        {
            throw $this->createNotFoundException('No ha sido posible borrar la solicitud.');
        }
        
        $solicitud = $repositorio->findOneBy(array('id' => $id));
        
        $repositorio->borrarSolicitud($solicitud);
        
        //Muestra un mensaje en el menú principal
        $this->get('session')->setFlash('aviso', 'La solicitud ha sido borrada con éxito.');
        
        //return $this->render('PermisoGestionBundle:Solicitud:exitoBorrado.html.twig');
        return $this->redirect($this->generateUrl('inicio_aplicacion'));
    }
    
    public function listarSolicitudesFinalizadasAction()
    {
        //Obtiene el usuario de la sesión
        $usuarioEnSesion = $this->getUser();
        
        //Recoge los datos
        $listaDeVacaciones = $this->getRepositorio('Vacaciones')->findby(array('empleado' => $usuarioEnSesion, 'finalizada' => true));
        $listaDePermisos = $this->getRepositorio('Permiso')->findBy(array('empleado' => $usuarioEnSesion, 'finalizada' => true));
        
        //Los muestra en la vista correspondiente
        return $this->render('PermisoGestionBundle:Solicitud:listaSolicitudesFinalizadas.html.twig', 
                array('vacaciones' => $listaDeVacaciones, 'permisos' => $listaDePermisos));
        
    }
    
    public function listarSolicitudesPendientesAprobacionAction()
    {
        //Obtiene el usuario de la sesión
        $usuarioEnSesion = $this->getUser();
        
        //Recoge los datos
        $listaDeVacaciones = $this->getRepositorio('Vacaciones')->findBy(array('empleado' => $usuarioEnSesion, 'finalizada' => false));
        $listaDePermisos = $this->getRepositorio('Permiso')->findBy(array('empleado' => $usuarioEnSesion, 'finalizada' => false));
        
        //Los muestra en la vista correspondiente
        return $this->render('PermisoGestionBundle:Solicitud:listaSolicitudesPendientes.html.twig', 
                array('vacaciones' => $listaDeVacaciones, 'permisos' => $listaDePermisos));
        
    }
    
    public function listarSolicitudesPendientesGestionAction()
    {
         //Obtiene el usuario de la sesión
         $usuarioEnSesionID = $this->getUser()->getId();
        
        $listaVacaciones = $this->getRepositorio('Vacaciones')->vacacionesPendientesGestionar($usuarioEnSesionID);
        $listaPermisos = $this->getRepositorio('Permiso')->permisosPendientesGestionar($usuarioEnSesionID);
        
        return $this->render('PermisoGestionBundle:Solicitud:listaSolicitudesPendientesGestion.html.twig', 
                array('vacaciones' => $listaVacaciones, 'permisos' => $listaPermisos));
    }
       
}

