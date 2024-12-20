<?php

namespace App\Form\Reservation;

use Symfony\Component\Intl\Countries;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
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
                
                'label' => 'Nom<span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre nom'
                    ),
                ]
            ])
            ->add('prenom',TextType::class,[
                
                'label' => 'Prénom<span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre prenom'
                    ),
                ]
            ])
            ->add('nationalite',CountryType::class,[
                
                'label' => 'Nationalité <span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre nationalité'
                    ),
                ]
            ])
            ->add('adresse1',TextType::class,[
                
                'label' => 'Adresse<span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre adresse'
                    ),
                ]
            ])
            ->add('adresse2',TextType::class,[
                
                'label' => 'Complément d\'adresse',
                "required" => false,
                "empty_data"=> ' ',
                'attr'=> [

                ]
            ])
            ->add('telephone',TelType::class,[
                
                'label' => 'Téléphone <span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [
                    // 'placeholder'=>'+33123456789',
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre numero de téléphone'
                    ),
                    new Regex(
                        pattern : '/^\+?\d{1,4}?\d{9,14}$/',
                        htmlPattern : '^\+?\d{1,4}?\d{9,14}$',
                        message : 'Veuillez entrer un numéro de téléphone valide et sans espaces.',

                    )
                ]
                
            ])
            ->add('email',EmailType::class,[
                
                'label' => 'Adresse email <span style="color:red;">*</span>',
                'label_html' => true,
                'attr'=> [
                    // 'placeholder'=>'adresse@email.fr',
                ],
                'constraints'=>[
                    new NotBlank(
                        message: 'Veuillez entrer votre adresse mail'
                    ),
                    new Regex(
                        pattern : '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                        message : 'Veuillez entrer une adresse email valide.',

                    )
                ]

            ])

            ->addEventListener(FormEvents::SUBMIT,[$this, 'getCountryFromCode'])
        ;

    }
    public function getCountryFromCode(SubmitEvent $event){
            // Récupération des données soumises (tableau)
            $formData = $event->getData();
            // dd($formData);
            $countryCode = $formData['nationalite'];
            $countries = Countries::getNames();
            if (isset($countries[$countryCode])) {
                $formData['nationalite']=($countries[$countryCode]); // Remplacer par le nom complet
                }

            $event->setData($formData);



    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
