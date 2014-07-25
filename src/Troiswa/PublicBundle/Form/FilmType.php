<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class FilmType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', 'text', array('required' => false))
            ->add('synopsis', 'textarea', array('required' => false))
            ->add('description' , 'textarea', array('required' => false))
            ->add('categorie' , 'entity' , array('class' => 'TroiswaPublicBundle:Categorie' , 'property' => 'titre' )) //Ajoute un select avec les catégorie
            -> add('dateCreation' , 'date', array('widget' => 'choice', 'years' => range(date("Y") ,'1900' ), 'required' => false))
            -> add('fichier', 'file')
            ->add('spectateurs', 'hidden',array('required' => false))
        ;


    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_films';
    }
}
