<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class ControllerDashboard extends Controller
{
    public function dash(Request $request, Response $response, Array $args)
    {
        $mensagem = new \Utils\Mensagem\Mensagem(1);
        $mensagem2 = new \Utils\Mensagem\Mensagem(0);
        $this->twigArgs->adcMensagem($mensagem);
        $this->twigArgs->adcMensagem($mensagem2);
        return $this->view->render($response, 'dashboard.twig', $this->twigArgs->retArgs());
    }
}