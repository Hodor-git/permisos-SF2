<?php

namespace Permiso\GestionBundle\Repositorios;

use Doctrine\ORM\EntityRepository;

class PermisoRepository extends EntityRepository
{
    public function guardarPermiso($permiso)
    {
        $em = $this->getEntityManager();
        
        $em->persist($permiso);
        $em->flush();
    }
}


