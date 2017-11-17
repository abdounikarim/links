<?php

namespace AppBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du lien',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => 'Lien associé',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('projects', EntityType::class, [
                'label' => 'Projets associés',
                'choice_label' => 'name',
                'class' => 'AppBundle\Entity\Project',
                'multiple' => true,
                'expanded' => true
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Link'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_link';
    }


}
