<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use App\Entity\Vente;
use App\Form\VenteType;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\AdminRecipient;

class VenteController extends EasyAdminController
{
    /**
     * @Route("/", name="services")
     */
    public function index()
    {
        return $this->render('home.html.twig', [
            'controller_name' => 'VenteController',
        ]);
    }

    /**
     * @Route("/email", name="email")
     */
    /*public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->to('contact@citeservices.yo.fr')
            ->from('csciteservices@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        $this->addFlash('notice', 'Email sent');

        return $this->redirectToRoute('services');
    }*/

    public function sendEmail(\Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('contact@citeservices.yo.fr')
            ->setTo('csciteservices@gmail.com')
            ->setBody('You should see me from the profiler!')
        ;

        $mailer->send($message);
        $this->addFlash('notice', 'Email sent');
        return $this->redirectToRoute('services');
    }

    /**
     * @Route("/invoice/create")
     */
    public function create(NotifierInterface $notifier)
    {
        // ...

        // Create a Notification that has to be sent
        // using the "email" channel
        $notification = (new Notification('New Invoice', ['email']))
            ->content('You got a new invoice for 15 EUR.');

        // The receiver of the Notification
        $recipient = new AdminRecipient(
            'hajaralambomanana@gmail.com'
           /* $user->getEmail(),
            $user->getPhonenumber()*/
        );

        // Send the notification to the recipient
        $notifier->send($notification, $recipient);

        // ...
    }
        
    

    /*public function createNewVenteEntity()
    {
        return new Vente($this->getUser());
    }*/
}
