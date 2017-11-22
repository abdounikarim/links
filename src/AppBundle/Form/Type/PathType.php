<?php

namespace AppBundle\Form\Type;

use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PathType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du parcours',
                'attr' => [
                    'class' => 'form-control'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'blabla'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du parcours',
                'required' => false,
                'attr' => [
                    'class' => 'form-control tinymce'
                ]
            ])
            ->add('url', UrlType::class, [
                'label' => 'Lien du parcours',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image associée'
            ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Path'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_path';
    }


}
