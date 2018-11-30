<?php

namespace App\Form;

use App\Entity\Language;
use App\Entity\PictureCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')

            ->add('languageSource', EntityType::class,[
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('languageAvailable', EntityType::class,[
                'class' => Language::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])

            ->add('isPublish')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PictureCategory::class,
        ]);
    }
}
