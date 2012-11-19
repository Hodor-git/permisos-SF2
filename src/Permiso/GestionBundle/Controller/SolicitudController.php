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
        $vacaciones = new Vacaciones();
        $form = $this->createForm(new VacacionesType(), $vacaciones);
        
        return $this->render('PermisoGestionBundle:Solicitud:vacacionesForm.html.twig', array('form' => $form->createView(),));
    }

}


