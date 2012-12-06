<?php

namespace Permiso\GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
                ->add('observaciones', 'textarea', array('label' => 'Observaciones: (Máx 200 caracteres)', 'max_length' => 200))
                ->add('tipoPermiso', 'entity', array(
                        'class' => 'PermisoGestionBundle:TipoPermiso',
                        'property' => 'descripcion',
                ));
        
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults(array(
            'data_class' => 'Permiso\GestionBundle\Entity\Solicitud',
        ));
    }
    
    public function getName()
    {
        return 'permiso';
    }
}


