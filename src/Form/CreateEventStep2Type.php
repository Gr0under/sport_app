<?php

namespace App\Form;

use App\Entity\SportEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportEvent::class,
        ]);
    }
}
