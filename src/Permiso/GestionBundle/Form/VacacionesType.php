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
                'years' => range(date('Y')+2, date('Y')),
                'label' => 'Fecha de Inicio:',
                ))
                ->add('observaciones', 'textarea', array('label' => 'Observaciones: (Máx 200 caracteres)', 'max_length' => 200))
                ->add('diasPedidos', 'integer', array('label' => 'Días Pedidos:'));
        
    }
    
    public function getName()
    {
        return 'vacaciones';
    }
}