<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class ControllerUsuario extends Controller
{
    public function home(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-dados.twig', $this->twigArgs->retArgs());
    }
}