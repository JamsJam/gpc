<?php

namespace App\Form\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TripType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('periode', TextType::class,[
                // 'widget' => 'single_text',
                // "html5" => false,
                'row_attr'=>[
                    'data-controller'=>"datepicker",
                    "data-datepicker-target"=>"datepicker"

                ]
            ])
            
            ->add('lieux', ChoiceType::class,[
                'expanded' => true,
                'multiple'=> true,
                'attr' => [
                    
                ],
                'choices' => [
                    'Grande Terre' => 'grande_terre',
                    'Basse Terre' => 'basse_terre',
                    'Les Saintes' => 'les_saintes',
                    'Marie Galante' => 'marie_galante',
                    'La Désirade' => 'la_desirade'
                ]
            ])
            
            ->add('duree', ChoiceType::class,[
                'expanded' => true,
                'multiple'=>true,
                'choices' => [
                    '8 jours/7 nuits' => '8_jours_7_nuits',
                    '10 jours/9 nuits' => '10_jours_9_nuits',
                    '12 jours/11 nuits' => '12_jours_11_nuits',
                    '15 jours/14 nuits' => '15_jours_14_nuits'
                ]
            ])
            
            ->add('produits_service', ChoiceType::class,[
                'expanded' => true,
                'multiple'=>true,
                'choices' => [
                    'Billet(s) d’avion' => 'billet_avion',
                    'Location de voiture' => 'location_voiture',
                    'Transfert' => 'transfert',
                    'VTC' => 'vtc',
                    'Hôtel' => 'hotel',
                    'Gîte' => 'gite',
                    'Bungalow' => 'bungalow',
                    'Appartement' => 'appartement',
                    'Villa' => 'villa',
                    'Activités' => 'activites',
                    'Excursions' => 'excursions'
                ]
            ])

            ->add('budget', ChoiceType::class,[
                'expanded' => false,
                'multiple'=>false,
                'choices' => [
                    "Votre budget" => "",
                    "moins de 1500" => "moins_de_1500",
                    "entre 1500 et 2000" => "entre_1500_et_2000",
                    "entre 2000 et 2500" => "entre_2000_et_2500",
                    "plus de 2500" => "plus_de_2500"
                ],

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
