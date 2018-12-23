<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Utils\Controller\Controller;

final class ControllerTest extends Controller
{
    public function sendEmail(Request $request, Response $response, Array $args)
    {
        /*$transport = (new \Swift_SmtpTransport('smtp.mailtrap.io', 465))
        ->setUsername('973b23511ee038')
        ->setPassword('86a91fa63d2cc5')
        ;*/

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($this->swiftTransport);

        // Create a message
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['renanonline8@gmail.com' => 'Renan Santos Gomes'])
            ->setTo(['renanonline8@gmail.com' => 'Renan Santos Gomes'])
            ->setBody('Here is the message itself')
        ;

        // Send the message
        $result = $mailer->send($message);
        if ($result) {
            return $response->write('Email Enviado');
        } else {
            return $response->withStatus(500)->write('Email Não Enviado');
        }
    }
}