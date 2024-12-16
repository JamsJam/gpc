<?php

namespace App\Form\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

class ConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('confirmation', CheckboxType::class,[
                "label" => "En cochant cette case, je certifie que les informations fournies sont exactes, et j'accepte la Politique de confidentialité de Guadeloupe Passion Caraïbes.",
                'label_html'=>true,
                'constraints'=>[
                    new IsTrue(
                        message: 'Veuillez accepter nos politiques de confidentialités pour continuer'
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
