<?php

namespace App\Form;

use App\Entity\SportEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CreateEventStep5Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             
           ->add('other_attributes', CollectionType::class, [
              "entry_type" => TextType::class, 
              'entry_options' => [
                  "attr" => [
                    "placeholder"=>"Votre caractéristique et sa valeur associée",
                    "class" => "form__addedFieldGroup--input", 
                    "data-materialCount" => "__name__",
                  ],
                  "label" => false, 
              ],
              'allow_add' => true,
              'allow_delete' => true, 
              "prototype" => true, 
              "label" => false, 
              "attr" => ['class' => "form__fieldFromDb"],
              
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
