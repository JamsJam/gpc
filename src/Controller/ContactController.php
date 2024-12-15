<?php

namespace App\Controller;

use App\Form\Contact\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){


            // dd($form->getData()['email']);


            for ($counter=0; $counter < 3; $counter++) { 
                if($counter != 1){
                    continue;
                }
                $emailInfo =  match ($counter) {
                    // 0 => [ //? Mail Explor
                    //     'to'=>'leads@explor.app',
                    //     'from'=>'contact@guadeloupepassioncaraibes.com',
                    //     'subject'=>'Nouveau contact - Formulaire de contact',
                    //     'template'=>'emails/contact/explor.html.twig',
                    // ],
                    // 1 => [//? Mail client
                    //     'to'=>$form->getData()['email'],
                    //     'from'=>'contact@guadeloupepassioncaraibes.com',
                    //     'subject'=>'Confirmation de reception du du formulaire de contact',
                    //     'template'=>'emails/contact/client.html.twig',
                    // ],

                    //!dev test purpose 
                    //todo remove in prod
                    1 => [//? Mail client
                        'to'=>$form->getData()['email'],
                        'from'=>'contact@fulljamdev.fr',
                        'subject'=>'Confirmation de reception du du formulaire de contact',
                        'template'=>'emails/contact/client.html.twig',
                    ],
                    // 2 => [//? Mail admin
                    //     'to'=>'contact@guadeloupepassioncaraibes.com',
                    //     'from'=>'contact@guadeloupepassioncaraibes.com',
                    //     'subject'=>'Nouveau formulaire de reçue - Guadeloupe Passion Caraïbes',
                    //     'template'=>'emails/contact/gpc.html.twig',
                    // ],
                    
                };
                $email = (new TemplatedEmail())
                    ->from($emailInfo['from'])
                    ->to($emailInfo['to'])
                    ->subject($emailInfo['subject'])
                    ->htmlTemplate($emailInfo['template'])
                    ->context(['client' => $form->getData()])
                ;

                $mailer->send($email);
            }

            //todo creer un App.flash
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé'
            );
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
