<?php

namespace Permiso\GestionBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; 

class PermisoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fechaInicio', 'date', array(
                'widget' => 'choice',
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')+1, date('Y')),
                'label' => 'Fecha de Inicio:',
                ))
                ->add('observaciones', 'text')
                ->add('tipoPermiso', 'choice', array(
                    'choices'   => array('asuntos_propios' => 'Asuntos Propios (1 Día)', 
                                         'traslado_misma_localidad' => 'Traslado Misma Localidad (1 Día)',
                                         'traslado_distinta_localidad' => 'Traslado Distinta Localidad (2 Días)', 
                                         'matrimonio' => 'Matrimonio (15 Días)'),
                    'required'  => false,
                    'label' => 'Tipo de Permiso:'
                ));
        
    }
    
    public function getName()
    {
        return 'permiso';
    }
}


