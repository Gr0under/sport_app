<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserInfosType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', null, [
                "label" => "Votre prénom et nom",
                "attr" => [
                    "placeholder" => "Prénom et nom"
                ],
                "row_attr" => [
                    "class" => "registerForm__field"
                ]
            ])
            ->add('pseudo', null, [
                "label" => "Votre nom d'utilisateur (visible sur le site)",
                "attr" => [
                    "placeholder" => "Nom d'utilisateur"
                ],
                "row_attr" => [
                    "class" => "registerForm__field"
                ]
            ])
            ->add('birthdate', DateType::class, [
                "label" => "Votre date de naissance",
                "attr" => [
                    "placeholder" => "Date de naissance"
                ],
                "row_attr" => [
                    "class" => "registerForm__field"
                ],
                'widget' => 'single_text',
                'format' => 'dd/mm/YYYY',
            ])
            ->add('address', null, [
                "label" => "Votre départment de résidence",
                "attr" => [
                    "placeholder" => "Département en 5 chiffres"
                ],
                "row_attr" => [
                    "class" => "registerForm__field"
                ]
            ])
            ->add('gender', ChoiceType::class, [
                "choices" => [
                    "Femme" => "female",
                    "Homme" => "male", 
                    "Autre" => "other", 
                ],
                "placeholder" => "Votre genre",
                "label" => "Votre genre",
                "attr" => [
                    "placeholder" => "Genre"
                ],
                "row_attr" => [
                    "class" => "registerForm__field"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
