<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class ControllerLogin extends Controller
{
    public function login(Request $request, Response $response, Array $args)
    {
        return $this->twig->render('login.twig');
    }

    public function cadastro(Request $request, Response $response, Array $args)
    {
        return $this->twig->render('cadastro.twig');
    }

    public function esqueceuSenha(Request $request, Response $response, Array $args)
    {
        return $this->twig->render('esqueceuSenha.twig');
    }

    public function entrar(Request $request, Response $response, Array $args)
    {
        return $response->withRedirect('../dashboard');
    }
}