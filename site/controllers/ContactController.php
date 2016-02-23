<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ContactController {

    public function contactAction(Request $request, Application $app) {
        $message = isset($_SESSION['message_sent']) ? true : false;
        unset($_SESSION['message_sent']);
        
        $news = $app['models']->getModel('ArticleModel')->getNews();
        $phones = explode(',' , $app['configs']->getData()['contact_phone']) ;
        return $app['twig']->render('contact.twig', array(
                    'message' => $message,
                    'menu' => $app['models']->Menu->byId(1),
                    'news' => $news,
                    'phones' => $phones
        ));
    }

    public function contactSentAction(Request $request, Application $app) {

        $data = $request->get('contact_form');
        $configData = $app['configs']->getData();
        $contactEmails = $configData['contact_phone'] ? explode(',' ,  $configData['contact_phone']) : array('secretariat@scoalachristiana.ro') ;
        
        $message = sprintf('
            Salut,
                    Ai primit un mesaj prin intermediul formularului de contact.
                    Mesaj: %s.
                    Primit la %s  de la %s cu adresa %s.', $data['mesaj'], date('d-m-Y H:i'), $data['nume'], $data['email']);

        $mailer = $app['mailer'];
        $mailer->isSMTP();

        $mailer->Host = 'localhost';
        //$mailer->Username = '';
        //$mailer->Password = '';
        //$mailer->SMTPSecure = 'ssl';
        $mailer->Port = 25;
        $mailer->setFrom('no-reply@scoalachristiana.ro');
        $mailer->addReplyTo($data['email']);
        foreach($contactEmails as $email) {
            $mailer->addAddress($email);
        }
        $mailer->Subject = 'Formular contact ';
        $mailer->Body = $message;
        $mailer->send();

        $_SESSION['message_sent'] = TRUE;
        return $app->redirect('/contact', 302);
    }

}

/*
 * 
 * 
 */