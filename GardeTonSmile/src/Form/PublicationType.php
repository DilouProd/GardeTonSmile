<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('imageFile', VichImageType::class, [
            'label' => 'Image (JPG ou PNG file)',
            'required' => false,
            'allow_delete' => false,
            'asset_helper' => true,
            'allow_delete' => true,
            'imagine_pattern' => 'squared_thumbnail_small',
        ])
        ->add('title', TextType::class)
        ->add('description', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
