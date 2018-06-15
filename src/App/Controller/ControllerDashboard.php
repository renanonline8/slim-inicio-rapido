<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

final class ControllerDashboard extends Controller
{
    public function dash(Request $request, Response $response, Array $args)
    {
        return $this->twig->render('dashboard.twig');
    }
}