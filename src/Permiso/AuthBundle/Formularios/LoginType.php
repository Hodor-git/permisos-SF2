<?php

namespace Permiso\AuthBundle\Formularios;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array('required' => false, 'attr'=> 
            array(
                'placeholder'=>'Nombre de usuario') 
        ));
        $builder->add('password', 'password', array('required' => false, 'attr'=> 
            array(
                'placeholder'=>'Contraseña')
        ));
    }
    
    public function getName()
    {
        //return 'login2';
    }
}