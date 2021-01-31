<?php

namespace App\Form;

use App\Controller\DishController;
use App\Entity\Dish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Dish1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $d=new DishController();
        $builder
            ->add('Name')
            ->add('Calories', ChoiceType::class, [
                'choices'  => $d->_availableCalories(),
            ])
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
