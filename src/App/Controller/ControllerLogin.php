<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Usuario;

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

    public function criarUsuario(Request $request, Response $response, Array $args)
    {
        // Hash de senha
        $senhaHash = \password_hash(
            $request->getParam('senha'),
            PASSWORD_DEFAULT,
            ['cost' == 12]
        );

        //Persistir usuário
        $usuario = new Usuario();
        $usuario->id_externo = uniqid();
        $usuario->email = $request->getParam('email');
        $usuario->senha = $senhaHash;
        $usuario->save();

        //Retornar para a página de login
        return $response->withRedirect('../login');
    }
}