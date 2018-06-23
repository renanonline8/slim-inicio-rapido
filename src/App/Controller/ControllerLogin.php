<?php
namespace App\Controller;

use Utils\Controller\Controller;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Usuario;
use App\Login\LoginSite;
use App\Sessao\SessaoNormal;

final class ControllerLogin extends Controller
{
    public function login(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'login.twig');
    }

    public function cadastro(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'cadastro.twig');
    }

    public function esqueceuSenha(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'esqueceuSenha.twig');
    }

    public function entrar(Request $request, Response $response, Array $args)
    {
        $login = new LoginSite(
            $request->getParam('email'),
            $request->getParam('senha')
        );
        $usuario = $login->logar();
        $sessaoNormal = new SessaoNormal();
        $sessao = $sessaoNormal->iniciar($usuario);
        if ($sessao->checaStatus()) {
            return $response->withRedirect('../dashboard');
        } else {
            return $response->withRedirect('../login');
        }
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

    public function sair(Request $request, Response $response, Array $args)
    {
        $sessaoNormal = new SessaoNormal();
        $sessaoNormal->sairSessao();
        $caminho = $this->router->pathFor('login');

        return $response->withRedirect($caminho);
    }
}