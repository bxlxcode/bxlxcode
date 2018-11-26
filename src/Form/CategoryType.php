<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\LanguageAvailable;
use App\Entity\LanguageSource;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description')

            ->add('languageSource', EntityType::class,[
                'class' => LanguageSource::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])

            ->add('languageAvailable', EntityType::class,[
                'class' => LanguageAvailable::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
