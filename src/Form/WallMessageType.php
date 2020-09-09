<?php

namespace App\Form;

use App\Entity\EventWallMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WallMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', null, [
                "label" => false, 
                "attr" => [
                    "placeholder" => "Ecrivez votre message" , 
                    "class" => "messageForm",
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventWallMessage::class,
        ]);
    }
}
