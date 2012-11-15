<?php

namespace Permiso\AuthBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PermisoAuthBundle:Default:index.html.twig', array());
    }
}
