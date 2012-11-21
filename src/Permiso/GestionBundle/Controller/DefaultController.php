<?php

namespace Permiso\GestionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * Si no hay usuario en sesión muestra el index. En caso
     * contrario muestra el menú principal de la aplicación.
     */
    public function indexAction()
    {
        $usuarioEnSesion = $this->getUser();
        
        if(is_null($usuarioEnSesion)) {
            return $this->render('PermisoGestionBundle:Default:index.html.twig');         
        }
        return $this->redirect($this->generateURL('inicio_aplicacion'));
    }
    
    /**
     * Controlador asignado al menú principal de la aplicación que
     * aparece una vez logueado el usuario
     */
    public function inicioAction()
    {       
        return $this->render('PermisoGestionBundle:Default:menuPrincipal.html.twig', array());
    }
    
    
    public function gestorAction()
    {
        return $this->render('PermisoGestionBundle:Default:gestor.html.twig', array());
    }
    
}
