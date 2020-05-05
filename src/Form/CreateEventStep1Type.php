<?php

namespace App\Form;

use App\Entity\SportEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateEventStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('sport', EntityType::class, ['class' => Sport::class])
            // ->add('description')
            // ->add('organiser')
            // ->add('location_dpt')
            // ->add('location_city')
            // ->add('location_address')
            // ->add('thumbnail')
            // ->add('player')
            // ->add('level')
            // ->add('level_description')
            // ->add('material')
            // ->add('assembly_point')
            // ->add('price_description')
            // ->add('distance')
            // ->add('pace')
            // ->add('created_at')
            // ->add('updated_at')
            // ->add('date')
            // ->add('time_start')
            // ->add('time_end')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportEvent::class,
        ]);
    }
}
