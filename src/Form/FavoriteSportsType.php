<?php

namespace App\Form;

use App\Entity\SportEvent;
use App\Entity\SportCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FavoriteSportsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('sport', EntityType::class, [
                'class' => SportCategory::class,
                'choice_label' => 'sport_name',

                'row_attr' => ['class' => 'createEventForm__sportChoice'], 
                'multiple' => true, 
                'expanded' => true, 
            ])
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportCategory::class,
        ]);
    }
}
