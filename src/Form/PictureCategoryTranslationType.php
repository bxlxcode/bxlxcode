<?php

namespace App\Form;

use App\Entity\PictureCategoryTranslation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureCategoryTranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('createdAt')
            ->add('updatedAt')
            ->add('name')
            ->add('description')
            ->add('isTranslated')
            ->add('languageAvailable')
            ->add('pictureCategory')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PictureCategoryTranslation::class,
        ]);
    }
}
