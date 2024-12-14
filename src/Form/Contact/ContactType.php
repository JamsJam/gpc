<?php

namespace App\Form\Contact;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,[
                'label'=>'Votre email :',
                
                'row_attr' =>[
                    'class' => 'field__container'
                ]
            ])
            ->add('nom',TextType::class,[
                'label'=>'Votre nom :',
                'row_attr' =>[
                    'class' => 'field__container'
                ]
            ])
            ->add('prenom',TextType::class,[
                'label'=>'Votre prénom :',
                'row_attr' =>[
                    'class' => 'field__container'
                ]
            ])
            ->add('message',TextareaType::class,[
                'label'=>'Votre message :',
                'row_attr' =>[
                    'class' => 'field__container'
                ]

            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
