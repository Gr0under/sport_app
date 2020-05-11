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

class CreateEventStep4Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('material', CollectionType::class, [
              "entry_type" => TextType::class, 
              'entry_options' => [
                  "attr" => [
                    "placeholder"=>"Un élément de matériel",
                    "class" => "form__addedFieldGroup--input", 
                    "data-materialCount" => "__name__",
                  ],
                  "label" => false, 
              ],
              'allow_add' => true,
              "prototype" => true, 
              "label" => false, 
              
           ])

           ->add('level', ChoiceType::class, [
              'choices'  => [
                     'Initiation' => 'Initiation',
                     'Tous niveaux' => 'Tous niveaux',
                     'Intermédiaire' => 'Intermédiaire',
                     'Confirmé' => 'Confirmé',
                     'Expert' => 'Expert',
                 ],
              'expanded' => true, 
              'label' => false, 
              'attr' => [ "class" => "form__group_options"],
           ])

           ->add('levelDescription', TextareaType::class, [
              'label' =>false, 
              'attr' => [
                  'placeholder' => 'Description du niveau requis pour participer (facultatif)', 
                  'class' => 'form__textArea',
              ],
              "required" => false, 
           ])

           ->add('priceDescription', TextareaType::class, [

              'label' =>false, 
              'attr' => [
                  'placeholder' => 'Description du coût impliqué par la participation (facultatif)', 
                  'class' => 'form__textArea',
              ],
              "required" => false,

           ])

           ->add('maxPlayers', NumberType::class, [
              'label' =>false, 
              'attr' => [
                  'placeholder' => 'Nombre total de participants', 
              ],
              "required" => true,

           ]); 
         
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SportEvent::class,
        ]);
    }
}
