<?php

namespace Permiso\GestionBundle\Form;
use Symfony\Component\Form\AbstractType;
//use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface; 

class VacacionesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaInicio', 'date', array(
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')+5, date('Y')),
                'label' => 'Fecha de Inicio'
                ))
                ->add('observaciones')
                ->add('diasPedidos', 'integer', array('rounding_mode' => 4, 'label' => 'Días Pedidos'));
        
    }
    
    public function getName()
    {
        return 'vacaciones_form';
    }
}