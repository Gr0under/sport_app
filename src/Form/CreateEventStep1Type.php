<?php

namespace App\Form;

use App\Entity\SportEvent;
use App\Entity\SportCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CreateEventStep1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('sportCategory', EntityType::class, [
                'class' => SportCategory::class,
                'choice_label' => 'sport_name',
                'label' => false,
                'placeholder' => 'Les Sports',
                'choice_attr' => ['class' => 'createEventForm__sportChoice'], 
            ])
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportEvent::class,
        ]);
    }
}
