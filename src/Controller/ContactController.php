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





            //mail to client
            $emailClient = (new TemplatedEmail())
                ->from('contact@guadeloupepassioncaraïbes.com')
                ->to(new Address('you@example.com'))
                ->subject('Contact Guadeloupe Passion Caraïbes')
                ->htmlTemplate('emails/contact/client.html.twig')
                ->context([])
                ;
            $mailer->send($emailClient);


            // mail to admin
            $emailPro = (new TemplatedEmail())
                ->from('contact@guadeloupepassioncaraïbes.com')
                ->to('contact@guadeloupepassioncaraïbes.com')
                ->subject('Nouveau Contact')
                ->htmlTemplate('emails/contact/gpc.html.twig')
                ->context([])
                ;

            $mailer->send($emailPro );

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
