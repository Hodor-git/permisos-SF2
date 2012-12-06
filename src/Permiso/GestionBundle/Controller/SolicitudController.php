<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Permiso\GestionBundle\Entity\Vacaciones;
use Permiso\GestionBundle\Form\VacacionesType;
use Permiso\GestionBundle\Entity\Permiso;
use Permiso\GestionBundle\Form\PermisoType;
use Permiso\GestionBundle\Form\ResolucionType;

use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Response;

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
    
    /**
     * 
     * @return type
     */
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
        
        //Obtiene el número de días de vacaciones que le quedan por consumir al empleado
        $diasDisponiblesVacaciones = $this->diasDisponiblesVacaciones($usuarioEnSesion);
        
        if($diasDisponiblesVacaciones <= 0)
        {
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Usted ha agotado los días de vacaciones disponibles. Por favor, para más
                información contacte con el administrador');
            
            return $this->render('PermisoGestionBundle:Solicitud:error.html.twig');
        }
        
        /**
         * Si el request viene de un POST
         */
        if($request->getMethod() == 'POST')
        {
            /*
             * Incorpora los parámetros recibidos desde el POST al objeto formulario
             */
            $form->bindRequest($request);
            //Recojo la fecha de inicio para ver si hay alguna solicitud activa con la misma
            $fechaInicio = $form->getData()->getFechaInicio();
            //Comprueba si ya existe una solicitud para esa fecha
            $existeFechaInicio = $this->existeSolicitudMismaFecha($fechaInicio, $usuarioEnSesion);
            
            if($existeFechaInicio) 
            {
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Ya existe una solicitud para la misma fecha!!');

            //Redirige
            return $this->redirect($this->generateURL('nuevas_vacaciones'));
            }
            
            //Obtiene el número de días solicitados vía POST
            $diasSolicitados = $form->getData()->getDiasPedidos();
            
            //Si el número de días solicitados es mayor que los días disponibles redirige y muestra el aviso correspondiente
            if($diasSolicitados > $diasDisponiblesVacaciones)
            {
               //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'Usted no dispone de tantos días de vacaciones. Solicite un nº menor, por favor');
                
                //Redirige
                return $this->redirect($this->generateURL('nuevas_vacaciones')); 
            }
            
            if($form->isValid())
            {
                //Obtiene el repositorio de la entidad y guarda ésta en la persistencia
                $this->getRepositorio('Solicitud')->guardarSolicitud($vacaciones, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido creada y guardada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', 
                array('form' => $form->createView(), 'valorSubmit' => 'Enviar', 'editar' => false, 
                    'diasVacacionesDisponibles' => $diasDisponiblesVacaciones));
    }
    
    public function editarVacacionesAction($id)
    {
        $vacaciones = $this->getRepositorio('Vacaciones')->findOneBy(array('id' => $id));
        
        //---Obtenemos el usuario de la sesión (objeto)
        $usuarioEnSesion = $this->getUser();
        
        //Obtiene el número de días de vacaciones que le quedan por consumir al empleado
        $diasDisponiblesVacaciones = $this->diasDisponiblesVacaciones($usuarioEnSesion);
        
        $form = $this->createForm(new VacacionesType, $vacaciones);
        
        $request = $this->getRequest();
        
        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            
            if($form->isValid())
            {
                $this->getRepositorio('Solicitud')->guardarSolicitud($vacaciones, $usuarioEnSesion);
                
                //Muestra un mensaje en el menú principal
                $this->get('session')->setFlash('aviso', 'La solicitud ha sido editada con éxito.');
                
                //Redirige
                return $this->redirect($this->generateURL('inicio_aplicacion'));
            }
        }
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', 
                array('form' => $form->createView(), 'valorSubmit' => 'Editar', 'editar' => true, 'id' => $id, 'diasVacacionesDisponibles' => $diasDisponiblesVacaciones));
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
            
            //Recojo la fecha de inicio para ver si hay alguna solicitud activa con la misma
            $fechaInicio = $form->getData()->getFechaInicio();
            
            //Comprueba si ya existe una solicitud para esa fecha
            $existeFechaInicio = $this->existeSolicitudMismaFecha($fechaInicio, $usuarioEnSesion);

            if($existeFechaInicio) 
            {
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Ya existe una solicitud para la misma fecha!!');

            //Redirige
            return $this->redirect($this->generateURL('nuevo_permiso'));
            }
            
            if($form->isValid())
            {   
                //Obtiene el repositorio de la entidad y guarda ésta en la persistencia
                $this->getRepositorio('Solicitud')->guardarSolicitud($permiso, $usuarioEnSesion);
                
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
                $this->getRepositorio('Solicitud')->guardarSolicitud($permiso, $usuarioEnSesion);
                
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
        //Obtengo la solicitud a mostrar
        $solicitud = $this->getRepositorio($tipo)->findOneBy(array('id' => $id));
        
//        try {
//            $solicitud = $this->getRepositorio($tipo)->findOneBy(array('id' => $id));
//        } catch (Exception $e) {
//            $this->render('PermisoGestionBundle:Solicitud:error.html.twig', array('error' => $e));
//        }
        
        if(!$solicitud)
        {
            throw $this->createNotFoundException('No es posible mostrar la solicitud. Por favor, inténtelo de nuevo.');
        }
        
        //Obtengo la ID del usuario en sesión
        $usuarioEnSesionID = $this->getUser()->getId();
        
        //Obtengo la ID del gestor a quien corresponde gestionar la solicitud
        $gestorAsignadoID = $solicitud->getEmpleado()->getGestor()->getId();
        
        //Si el usuario en sesión es gestor y le corresponde a él gestionar la solicitud
        if($this->get('security.context')->isGranted('ROLE_GESTOR') && ($usuarioEnSesionID == $gestorAsignadoID))
        {
            $form = $this->createForm(new ResolucionType);
            
            //Muestra la plantilla de solicitud pendiente de gestión
            return $this->render('PermisoGestionBundle:Solicitud:solicitudPendienteGestion.html.twig', array('solicitud' => $solicitud, 'tipo' => $tipo, 'form' => $form->createView()));
        //Si el usuario no cumple ambas condiciones anteriores se muestra la solicitud con la posibilidad de eliminarla.
        } else {
            return $this->render('PermisoGestionBundle:Solicitud:mostrarSolicitud.html.twig', array('solicitud' => $solicitud, 'tipo' => $tipo));
        }  
        
    }
    
    public function borrarSolicitudAction($id)
    {
        $repositorio = $this->getRepositorio('Solicitud');
        
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
        
        //Obtiene el repositorio
        $solicitudRepo = $this->getRepositorio('Solicitud');
        
        //Recoge las solicitudes para listar
        $listaVacaciones = $solicitudRepo->solicitudPendienteGestionar($usuarioEnSesionID, '\Vacaciones');
        $listaPermisos = $solicitudRepo->solicitudPendienteGestionar($usuarioEnSesionID, '\Permiso');
        
        return $this->render('PermisoGestionBundle:Solicitud:listaSolicitudesPendientesGestion.html.twig', 
                array('vacaciones' => $listaVacaciones, 'permisos' => $listaPermisos));
    }
    
    public function gestionarSolicitudAction($id)
    {
        $solicitud = $this->getRepositorio('Solicitud')->findOneBy(array('id' => $id));
        
        //Obtiene el request
        $request = $this->getRequest();
        
        //Obtiene el contenido del campo resolución dentro del formulario
        $resolucion = $request->get('resolucion');
        
        //Si se pulsa dos veces el botón de Aceptar/Rechazar....
        if($solicitud->getFinalizada() == TRUE)
        {
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Esta solicitud ya ha sido gestionada. Para más información contacte con el administrador');

            //return $this->render('PermisoGestionBundle:Solicitud:exitoBorrado.html.twig');
            return $this->redirect($this->generateUrl('inicio_aplicacion'));
        }
        
        //Si se ha pulsado el botón de aceptar la solicitud...
        if($this->getRequest()->request->has('aceptar'))
        {
            //Se graba la solicitud en la BDD con el campo "Denegada" igual a false
            $this->getRepositorio('Solicitud')->gestionarSolicitudRepositorio(false, $resolucion['resolucion'], $solicitud);
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Solicitud aceptada y gestionada correctamente.');
            //Envía un correo al empleado con la resolución de la solicitud.
            //$this->enviarCorreo();
            //Redirige al menú principal de la aplicación
            return $this->redirect($this->generateUrl('inicio_aplicacion'));
            
          //Si se ha pulsado el botón de rechazar la solicitud...  
        } else {
            //Se graba la solicitud en la BDD con el campo "Denegada" igual a true
            $this->getRepositorio('Solicitud')->gestionarSolicitudRepositorio(true, $resolucion['resolucion'], $solicitud);
            //Muestra un mensaje en el menú principal
            $this->get('session')->setFlash('aviso', 'Solicitud rechazada y gestionada correctamente.');
            //Envía un correo al empleado con la resolución de la solicitud.
            //$this->enviarCorreo();
            //Redirige al menú principal
            return $this->redirect($this->generateUrl('inicio_aplicacion'));
        }          
    }
    
    /**
     * Recoge una instancia de la clase MailHelper y envía un correo
     * mediante el método sendEmail.
     * @param String $resolucion (resolución de la solicitud)
     */
    private function enviarCorreo($resolucion)
    {
        $this->get('mail_helper')->sendEmail('lorathlon@gmail.com', 'nerthalas@gmail.com', $resolucion, 'Resolución de su solicitud');
        
//        try {
//             $this->get('mailer')->send($email);
//            }
//            catch (\Swift_TransportException $e) {
//            $result = array(
//                false, 
//                'There was a problem sending email: ' . $e->getMessage()
//            );
//        }
    }
    
    /**
     * Genera un documento PDF con los principales datos de
     * la solicitud.
     * @Pdf()
     */
    public function generarPDFAction($tipo, $id)
    {
        $facade = $this->get('ps_pdf.facade');
        
        $response = new Response();
        
        $solicitud = $this->getRepositorio($tipo)->findOneBy(array('id' => $id));  
        
        $this->render('PermisoGestionBundle:Solicitud:PDFSolicitud.pdf.twig', array('solicitud' => $solicitud, 'tipo' => $tipo), $response);

        $xml = $response->getContent();
        
        $contenido = $facade->render($xml);
        
        return new Response($contenido, 200, array('content-type' => 'application/pdf'));
               
    }
    
    /**
     * Método que comprueba en la persistencia si ya existe una solicitud
     * activa con la misma fecha de inicio.
     * @param type $fechaInicio
     * @param type $usuarioEnSesion
     * @return boolean (True: existe, False: no existe)
     */
    private function existeSolicitudMismaFecha($fechaInicio, $usuarioEnSesion)
    {
        $existeSolicitudMismaFecha = $this->getRepositorio('Solicitud')
                ->findOneBy(array('fechaInicio' => $fechaInicio, 'empleado' => $usuarioEnSesion, 'finalizada' => false));
        
        if(is_null($existeSolicitudMismaFecha))
        {
            return false;
        } else {
            return true;
        }  
        
    }
    
    private function diasDisponiblesVacaciones($empleadoEnSesion)
    {
        $diasVacacionesPorCategoria = $this->diasVacacionesPorCategoria($empleadoEnSesion);
        
        $repositorio = $this->getRepositorio('Solicitud');
        $diasConsumidos = $repositorio->diasVacacionesConsumidosPorEmpleado($empleadoEnSesion);
        
        $diasDisponibles = $diasVacacionesPorCategoria - $diasConsumidos;
        
        if($diasDisponibles <= 0)
        {
            return 0;
        } else 
        {
            return $diasDisponibles;  
        }
    }
    
    private function diasVacacionesPorCategoria($empleadoEnSesion)
    {
        return $empleadoEnSesion->getCategoria()->getDiasVacaciones();
    }
       
}
