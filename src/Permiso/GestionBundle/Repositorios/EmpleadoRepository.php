<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class EmpleadoRepository extends EntityRepository
{
    public function grabarEmpleado($empleado)
    {  
//        $categoria = $em->getRepository('PermisoGestionBundle:Categoria');
//        
//        //$pepito = $gestor->findBy(array('username' => 'pepe'));
//        $empleado = $categoria->findBy(array('nombre' => 'gestor'));
//        
//        $manolito = new Gestor();
//        
//        $manolito->setUsername('javi');
//        $manolito->setPassword('montes');
//        $manolito->setEmail('montes@montes.dot.com');
//        $manolito->setCategoria($empleado[0]);
//        //$manolito->setGestor($pepito[0]);
        
        $em = $this->getEntityManager();
        
        $this->setSecurePassword($empleado);
                   
        $em->persist($empleado);
        
        $em->flush();
    }
    
    private function setSecurePassword(&$entity) 
    {
	$entity->setSalt(md5(time()));
	$encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder('sha512', true, 10);
	$password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
	$entity->setPassword($password);
    }
    
    public function tonteria()
    {
        $em = $this->getEntityManager();
    }
}


