<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use App\Service\EncryptionService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\Reservation\TripType as ReservationType2;
use App\Form\Reservation\ContactType as ReservationType1;
use App\Form\Reservation\ConfirmationType as ReservationType3;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController
{


    public function __construct(

        private EncryptionService $cryptage

    ) {}

    #[Route('/reservation', name: 'app_reservation')]
    public function index(Request $request): Response
    {

        $session = $request->getSession();
        $form = $this->createForm(ReservationType1::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // $contactInfo = $form->getData();
            // $encryptInfo = array_map([$this->cryptage, 'encrypt'],$contactInfo);
            // $dencryptInfo = array_map([$this->cryptage, 'decrypt'],$encryptInfo);
            // dd($contactInfo,$encryptInfo,$dencryptInfo);


            $session->set('contactInfo', $this->cryptRecursively($form->getData()));
            return $this->redirectToRoute('app_reservation_trip');
        }


        return $this->render('reservation/contactForm.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/reservation/trip', name: 'app_reservation_trip')]
    public function trip(Request $request): Response
    {

        $session = $request->getSession();
        $form = $this->createForm(ReservationType2::class);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // dd($form->getData());
            $session->set('tripInfo', $this->cryptRecursively($form->getData(), 1));

            return $this->redirectToRoute('app_reservation_confirm');
        }


        return $this->render('reservation/tripForm.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/reservation/confirm', name: 'app_reservation_confirm')]
    public function confirm(Request $request, MailerInterface $mailer): Response
    {

        $session = $request->getSession();
        $form = $this->createForm(ReservationType3::class);
        // ? recupéré les info dans la session
        //? les decrypter
        $sejourInfo = $this->cryptRecursively(array_merge($session->get('contactInfo'),$session->get('tripInfo')),2);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //? envoyer mail à l'utilisateur
            //? envoyer mail à l'admin
            //? envoyer mail à l'explor

            for ($counter=0; $counter < 3; $counter++) { 
            
                $emailInfo =  match ($counter) {
                    0 => [ //? Mail Explor
                        'to'=>'leads@explor.app',
                        'from'=>'contact@guadeloupepassioncaraibes.fr',
                        'subject'=>'Nouvelle réservation - Informations de séjour',
                        'template'=>'emails/reservations/explor.html.twig',
                    ],
                    1 => [//? Mail client
                        'to'=>strval($sejourInfo['email']),
                        'from'=>'contact@guadeloupepassioncaraibes.fr',
                        'subject'=>'Confirmation de votre réservation chez Passion Caraïbes',
                        'template'=>'emails/reservations/client.html.twig',
                    ],
                    2 => [//? Mail admin
                        'to'=>'contact@guadeloupepassioncaraibes.fr',
                        'from'=>'contact@guadeloupepassioncaraibes.fr',
                        'subject'=>'Nouvelle réservation reçue - Guadeloupe Passion Caraïbes',
                        'template'=>'emails/reservations/gpc.html.twig',
                    ],
                };
                $email = (new TemplatedEmail())
                    ->from($emailInfo['from'])
                    ->from($emailInfo['to'])
                    ->subject($emailInfo['subject'])
                    ->htmlTemplate($emailInfo['template'])
                    ->context(['infoSejour' => $sejourInfo])
                ;

                $mailer->send($email);
            }


            //? creer un App.flash
            $this->addFlash(
                'success',
                'Votre message a bien été envoyé'
            );
            //? redirect to home
            return $this->redirectToRoute('app_home');
            
            // $contactInfo = $form->getData();
            // $encryptInfo = array_map([$this->cryptage, 'encrypt'],$contactInfo);
            // $dencryptInfo = array_map([$this->cryptage, 'decrypt'],$encryptInfo);
            // dd($contactInfo,$encryptInfo,$dencryptInfo);


            
        }


        return $this->render('reservation/confirmForm.html.twig', [
            'form' => $form,
            'sejour' => $sejourInfo
        ]);
    }



    private function cryptRecursively(array $array, int $action = 1): array
    {

        $callback = match ($action) {
            1 => [$this->cryptage, 'encrypt'],
            2 => [$this->cryptage, 'decrypt'],
        };
        // $callback = [$this->cryptage, 'encrypt'];

        // Parcourt chaque élément du tableau
        foreach ($array as $key => $value) {
            // Si l'élément est un tableau, on appelle la fonction récursivement
            if (is_array($value)) {
                $array[$key] = $this->cryptRecursively($value, $action);
            } else {
                // Sinon, on applique la fonction au niveau de l'élément
                $array[$key] = $callback($value);
            }
        }
        return $array;
    }
}
