<?php
namespace App\Controller;

use Utils\Controller\Controller;
use Utils\URLs\AddMsgUrl;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Usuario;
use App\Login\LoginSite;
use App\Sessao\SessaoNormal;
use App\Validacao\ValidacaoRedireciona;

final class ControllerLogin extends Controller
{
    public function login(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'login.twig', $this->twigArgs->retArgs());
    }

    public function cadastro(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'cadastro.twig', $this->twigArgs->retArgs());
    }

    public function esqueceuSenha(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'esqueceuSenha.twig', $this->twigArgs->retArgs());
    }

    /**
     * Controller de quando é enviado solicitação de enviar senha
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return void
     */
    public function enviarEsqueceuSenha(Request $request, Response $response, Array $args)
    {
        $goTo = $this->router->pathFor('login');
        $url = new AddMsgUrl($goTo);
        $url->add('mensagens', 10);
        $url->add('aviso', 9);
        $url->add('mensagens', 9);
        var_dump($url->returnUrl());
        die();
        $goTo .= '?mensagens=10';
        return $response->withRedirect($goTo);
    }

    public function entrar(Request $request, Response $response, Array $args)
    {
        $login = new LoginSite(
            $request->getParam('email'),
            $request->getParam('senha')
        );
        
        $validaLogin = new ValidacaoRedireciona('../login');
        $validaLogin->adicionaRegra($login->consultaUsuario(), 4);
        $validaLogin->adicionaRegra($login->verificarSenha(), 5);
        if (!$validaLogin->valida()) {
            return $response->withRedirect($validaLogin->retornaURLErros());
        }
        
        $usuario = $login->logar();
        
        $sessaoNormal = new SessaoNormal();
        $sessao = $sessaoNormal->iniciar($usuario);
        
        $validaSessao = new ValidacaoRedireciona('../login');
        $validaSessao->adicionaRegra($sessao->checaStatus(), 6);
        if (!$validaSessao->valida()) {
            return $response->withRedirect($validaSessao->retornaURLErros());
        }
        
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
        $usuario->nome = $request->getParam('nome');
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