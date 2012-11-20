<?php

namespace Permiso\GestionBundle\Entity;

use Doctrine\ORM\EntityRepository;
/**
 * Description of VacacionesRepository
 *
 * @author Espe y Javi
 */
class VacacionesRepository extends EntityRepository
{
    public function guardarVacaciones($vacaciones)
    {
        $em = $this->getEntityManager();
        
        $em->persist($vacaciones);
        $em->flush();
    }    
}

