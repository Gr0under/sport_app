<?php

namespace App\Form;

use App\Entity\SportEvent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class CreateEventStep3Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('location_city', null, [
              "attr" => ["placeholder"=>"Votre ville"],
              "label" => false,
           ])
           ->add('location_address', TextType::class, [
              "attr" => ["placeholder"=>"Adresse du rendez-vous"],
              "label" => false,
           ])

           ->add('location_description', null, [
              'label' =>false, 
              'attr' => [
                  'placeholder' => 'Donnez des précisions sur le point de rendez-vous pour que l\'on vous retrouve facilement (facultatif)', 
                  'class' => 'form__textArea',
              ],
           ])

           ->add('location_dpt', HiddenType::class)

           ->add('date', DateType::class, [
              "label" => false, 
              "widget" => 'single_text',
              'html5' => false,
              "attr" => ["placeholder"=>"Choisir une date"],
              'format' => 'dd-MM-yyyy',
           ])
           ->add('time_start', TimeType::class, [
              "label" => false, 
              "widget" => 'single_text',
              "attr" => ["placeholder"=>"Heure de début"], 
             
           ])
           ->add('time_end', TimeType::class, [
              "label" => false, 
              "widget" => 'single_text',
              "attr" => ["placeholder" => "Heure de fin"],
              
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
