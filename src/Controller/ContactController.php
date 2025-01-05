<?php

namespace App\Controller;

use App\Form\Contact\ContactType;
use App\Service\ExploreApiService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MailerInterface $mailer, ExploreApiService $explorApi): Response
    {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $contactFormData = $form->getData();

            //? ===========Leads creation
            $leads = [
                "name" => $contactFormData['prenom'].' '.$contactFormData['nom'],
                "email" => $contactFormData['email'],
                "comment" => "contact form -  Message du prospect :  ".$contactFormData['message']
            ];
            //! await Explore Validatino
            // $explorApi->sendLeadsToExplore($leads);
            
            //? ===========Mail Admin & client
            for ($counter=0; $counter < 2; $counter++) { 
                //! ====dev test purpose
                if($counter != 3){
                        continue;
                    }
                //! ------------------
                $emailInfo =  match ($counter) {
                    0 => [//? Mail client
                        'to'=>$contactFormData['email'],
                        'subject'=>'Confirmation de reception du du formulaire de contact',
                        'template'=>'emails/contact/client.html.twig',
                    ],
                    1 => [//? Mail admin
                        'to'=>'contact@guadeloupepassioncaraibes.com',
                        'subject'=>'Nouveau formulaire de reçue - Guadeloupe Passion Caraïbes',
                        'template'=>'emails/contact/gpc.html.twig',
                    ],
                };
                $email = (new TemplatedEmail())
                    ->from("contact@guadeloupepassioncaraibes.com")
                    ->to($emailInfo['to'])
                    ->subject($emailInfo['subject'])
                    ->htmlTemplate($emailInfo['template'])
                    ->context(['client' => $contactFormData])
                ;

                $mailer->send($email);
            }
 

            //todo creer un App.flash
            $this->addFlash(
                'success_form',
                'Votre message à bien été envoyé'
            );

            return $this->redirectToRoute(
                "app_home",
                [],
                303
            );
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
