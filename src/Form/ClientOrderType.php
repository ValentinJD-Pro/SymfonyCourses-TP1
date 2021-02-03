<?php

namespace App\Form;

use App\Entity\ClientOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', DateTimeType::class, [
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => true
            ])
            ->add('prixTotal')
            ->add('state', ChoiceType::class, [
                'choices'  => [
                    'Prise' => "Prise",
                    'Préparée' => "Préparée",
                    'Servie' => "Servie",
                    'Payée' => "Payée"
                ],
                'required' => true
            ])
            ->add('user')
            ->add('clientTable')
            ->add('dish')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClientOrder::class,
        ]);
    }
}
