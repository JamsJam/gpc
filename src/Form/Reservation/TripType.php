<?php

namespace App\Form\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                "label" => 'Période de votre sejour <span style="color:red;">*</span>',
                'label_html' => true, 
                'row_attr'=>[
                    'data-controller'=>"datepicker",
                    "data-datepicker-target"=>"datepicker",
                    "class" => "field__container"

                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre période de séjours'
                    ),
                ]
            ])
            
            ->add('lieux', ChoiceType::class,[
                'expanded' => true,
                'multiple'=> true,
                'label' => 'Lieux souhaité <span style="color:red;">*</span>',
                'label_html' => true,
                'attr' => [
                    
                ],
                'choices' => [
                    'Grande Terre' => 'grande_terre',
                    'Basse Terre' => 'basse_terre',
                    'Les Saintes' => 'les_saintes',
                    'Marie Galante' => 'marie_galante',
                    'La Désirade' => 'la_desirade'
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre destination'
                    ),
                ]
            ])
            
            ->add('duree', ChoiceType::class,[
                "label" => 'Durée souhaitée <span style="color:red;">*</span>',
                'label_html' => true,
                'expanded' => true,
                'multiple'=>true,
                'choices' => [
                    'moins de 8 jours' => 'moins_de_8_jours',
                    '8 jours/7 nuits' => '8_jours_7_nuits',
                    '10 jours/9 nuits' => '10_jours_9_nuits',
                    '12 jours/11 nuits' => '12_jours_11_nuits',
                    '15 jours/14 nuits' => '15_jours_14_nuits',
                    'plus de 15 jours' => 'plus_de_15_jours'
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez renseigner la durée de votre sejour'
                    ),
                ]
            ])
            
            ->add('produits_service', ChoiceType::class,[
                'label' => 'Produits et services <span style="color:red;">*</span>',
                'label_html' => true,
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
                    'Excursions' => 'excursions',
                    'Autre' => 'autre',
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre adresse'
                    ),
                ]
            ])

            ->add('budget', ChoiceType::class,[
                'label'=> 'Votre budget <span style="color:red;">*</span>',
                'label_html' => true,
                'expanded' => false,
                'multiple'=>false,
                'choices' => [
                    "Votre budget" => "",
                    "moins de 1500" => "moins_de_1500",
                    "entre 1500 et 2000" => "entre_1500_et_2000",
                    "entre 2000 et 2500" => "entre_2000_et_2500",
                    "plus de 2500" => "plus_de_2500"
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez renseigner votre budget'
                    ),
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
