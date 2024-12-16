<?php

namespace App\Form\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                
                'label' => 'Nom',
                'attr'=> []
            ])
            ->add('prenom',TextType::class,[
                
                'label' => 'Prénom',
                'attr'=> []
            ])
            ->add('nationalite',CountryType::class,[
                
                'label' => 'Nationalité',
                'attr'=> [],
                'data' => 'FR',
            ])
            ->add('adresse1',TextType::class,[
                
                'label' => 'Adresse',
                'attr'=> []
            ])
            ->add('adresse2',TextType::class,[
                
                'label' => 'Complément d\'adresse',
                "require" => 'false',
                'attr'=> [

                ]
            ])
            ->add('telephone',TelType::class,[
                
                'label' => 'Téléphone',
                'attr'=> [
                    // 'placeholder'=>'+33123456789',
                ],
                
            ])
            ->add('email',EmailType::class,[
                
                'label' => 'Adresse email',
                'attr'=> [
                    // 'placeholder'=>'adresse@email.fr',
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
