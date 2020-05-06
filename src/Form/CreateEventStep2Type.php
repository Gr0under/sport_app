<?php

namespace App\Form;

use App\Entity\SportEvent;
use App\Entity\SportCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CreateEventStep2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' =>false, 
                'attr' => ['placeholder' => 'Titre de mon évènement'],
            ])
            ->add('description',null, [
                'label' =>false, 
                'attr' => [
                    'placeholder' => 'Description de l\'évènement',
                    'class' => 'createEventForm__textArea',
                ],
            ])

            ->add('thumbnail', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportEvent::class,
        ]);
    }
}
