<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\NotBlank; 
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\IsTrue;

class DeletePlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('message', TextareaType::class, [
              "attr" => ["placeholder"=>"Votre message", "class" => "form__textArea form__textArea--mb"],
              "required" => false, 
           ])
            ->add('confirmDelete', CheckboxType::class, [
                "label" => "Je confirme la suppression de ce participant", 
                "constraints" => [

                    new IsTrue(["message"=>"Veuillez confirmer la supppression du participant"]),

                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
