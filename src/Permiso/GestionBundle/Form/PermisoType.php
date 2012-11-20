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
                ->add('tipoPermiso', 'entity', array(
                        'class' => 'PermisoGestionBundle:TipoPermiso',
                        'property' => 'descripcion',
                ));
        
    }
    
    public function getName()
    {
        return 'permiso';
    }
}


