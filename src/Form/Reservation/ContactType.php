<?php

namespace App\Form\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                
                'label' => '',
                'attr'=> []
            ])
            ->add('prenom',TextType::class,[
                
                'label' => '',
                'attr'=> []
            ])
            ->add('nationalite',CountryType::class,[
                
                'label' => '',
                'attr'=> []
            ])
            ->add('adresse1',TextType::class,[
                
                'label' => '',
                'attr'=> []
            ])
            ->add('adresse2',TextType::class,[
                
                'label' => '',
                'attr'=> []
            ])
            ->add('telephone',NumberType::class,[
                
                'label' => '',
                'attr'=> []
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
