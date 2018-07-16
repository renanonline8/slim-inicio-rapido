<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Usuario;

final class ControllerUsuario extends Controller
{
    public function home(Request $request, Response $response, Array $args)
    {
        $dadosSessao = $this->twigArgs->retArgs('sessao');
        $usuario = Usuario::find_by_id_externo($dadosSessao['id']);
        $dadosUsuario = $usuario->to_array(array(
            'except' => 'senha'
        ));
        $this->twigArgs->adcDados('usuario', $dadosUsuario);
        return $this->view->render($response, 'usuario-dados.twig', $this->twigArgs->retArgs());
    }
    
    public function alterarEmail(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-email.twig', $this->twigArgs->retArgs());
    }
    
    public function alterarSenha(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-senha.twig', $this->twigArgs->retArgs());
    }
    
    public function excluirConta(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-excluir.twig', $this->twigArgs->retArgs());
    }
}