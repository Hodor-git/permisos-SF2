<?php
 
namespace Permiso\AuthBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Permiso\AuthBundle\Entity\Usuario;

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
        $entity  = new Usuario();
        
        $entity->setUsuario('pepito');
        $entity->setPassword('piscinas');
        $this->setSecurePassword($entity);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity);
        $em->flush();
        
        return $this->render('PermisoAuthBundle:Security:exito.html.twig');
        */
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PermisoAuthBundle:Usuario')->find(1);
        $permisos = $entity->getRoles();
        return $this->render('PermisoAuthBundle:Security:exito.html.twig', array('nombre' => $entity, 'permiso' => var_dump($permisos)));
    }
    
    private function setSecurePassword(&$entity) 
    {
	$entity->setSalt(md5(time()));
	$encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
	$password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
	$entity->setPassword($password);
    }
    
    public function mostrar()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PermisoAuthBundle:Usuario')->find(1);
        return $this->render('PermisoAuthBundle:Security:exito.html.twig', array('nombre' => $entity->getUsuario));
    }
    
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
    
    public function logoutAction()
    {
        $this->get('security.context')->setToken(null); 
        $this->get('request')->getSession()->invalidate();
        
        return $this->render('PermisoAuthBundle:Security:logout.html.twig');
    }
}