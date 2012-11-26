<?php

namespace Permiso\GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class ResolucionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('resolucion', 'textarea', array('label' => 'Resolución: (Máx 200 caracteres)', 'max_length' => 200));
    }
    
    public function getName()
    {
        return 'resolucion';
    }
}