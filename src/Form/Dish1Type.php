<?php

namespace App\Form;

use App\Entity\Dish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Dish1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Calories')
            ->add('Price')
            ->add('Image',null,[
                'required' =>false,
                'empty_data'=>'http://via.placeholder.com/200x200',
            ])
            ->add('Description')
            ->add('Sticky')
            ->add('Category')
            ->add('User')
            ->add('allergens')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dish::class,
        ]);
    }
}
