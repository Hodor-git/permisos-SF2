<?php
 
namespace Permiso\AuthBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Permiso\AuthBundle\Entity\Usuario;
use Permiso\GestionBundle\Entity\Empleado;
use Permiso\GestionBundle\Entity\Gestor;
use Permiso\GestionBundle\Entity\Categoria;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
 
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render('PermisoAuthBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    
    public function registrarUsuarioAction()
    {  
        /*
        $em = $this->getDoctrine()->getEntityManager();
        
        $gestor = $em->getRepository('PermisoGestionBundle:Gestor');
        $categoria = $em->getRepository('PermisoGestionBundle:Categoria');
        
        //$pepito = $gestor->findBy(array('username' => 'pepe'));
        $empleado = $categoria->findBy(array('nombre' => 'gestor'));
        
        $manolito = new Gestor();
        
        $manolito->setUsername('pepito');
        $manolito->setPassword('piscinas');
        $manolito->setEmail('pepito@pepito.dot.com');
        $manolito->setCategoria($empleado[0]);
        //$manolito->setGestor($pepito[0]);
        
        $this->setSecurePassword($manolito);
        
        $em->persist($manolito);
        
        $em->flush();*/
        
        return $this->render('PermisoGestionBundle:Solicitud:exitoBorrado.html.twig');
    }
    
    private function setSecurePassword(&$entity) 
    {
	$entity->setSalt(md5(time()));
	$encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
	$password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
	$entity->setPassword($password);
    }
    
//    public function mostrar()
//    {
//        $em = $this->getDoctrine()->getEntityManager();
//
//        $entity = $em->getRepository('PermisoAuthBundle:Usuario')->find(1);
//        return $this->render('PermisoAuthBundle:Security:exito.html.twig', array('nombre' => $entity->getUsuario));
//    }
    
    public function loginHelperAction()
    {
        $usuario = $this->getUser();
        
        if(is_null($usuario)) {
            $usuario = 'invitado';
            
            return $this->render('PermisoAuthBundle:Security:nologin.html.twig');
        } else {
            return $this->render('PermisoAuthBundle:Security:loggued.html.twig', array ('usuario' => $usuario));
        }
    }
    
    /*public function logoutAction()
    {
        $this->get('security.context')->setToken(null); 
        $this->get('request')->getSession()->invalidate();
        
        return $this->render('PermisoAuthBundle:Security:logout.html.twig');
    }*/
}