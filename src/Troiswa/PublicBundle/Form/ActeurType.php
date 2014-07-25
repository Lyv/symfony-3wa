<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ActeurType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add('prenom', 'text', array('required' => false)) #Requires = false enlève la condition d'html5
            -> add('nom' , 'text', array('required' => false))
            -> add('dateNaissance' , 'date', array('widget' => 'choice', 'years' => range(date("Y") ,'1900' ), 'required' => false))
            -> add ('sexe' , 'choice', array('choices' => array('F' => 'Femme', 'M' => 'Homme'), 'expanded' => true, 'data' => 'F'), array('required' => false) )
            -> add ('nationalite', null, array('required' => false))
            -> add('fichier', 'file')
            -> add ('biographie',null, array('required' => false))
          ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Acteur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_acteur';
    }
}
