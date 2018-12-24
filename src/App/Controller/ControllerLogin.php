<?php
namespace App\Controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

use Utils\Controller\Controller;
use Utils\URLs\ParameterURL;
use Utils\ForgotPass\ForgotPassJwt;

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
        //Obter e-mail
        $email = $request->getParam('email');

        //Obter id externo
        $user = Usuario::find_by_email($email);
        $goToError = $this->router->pathFor('login-esqueceu-senha');
        if (empty($user)){
            $urlErrorUsr = new ParameterURL($goToError);
            $urlErrorUsr->add('mensagens', 4);
            return $response->withRedirect($urlErrorUsr->returnUrl());
        }
        $idExt = $user->id_externo;

        //Obter nome
        $usrName = $user->nome; 

        //Gerar Data atual
        $date = new \DateTime();

        //Gerar Token
        $token = $this->forgotPassJwt->createToken($idExt, $date);
        $url = 
            $request->getUri()->getScheme() . 
            '://' . 
            $request->getUri()->getHost() . 
            $this->router->pathFor(
            'nova-senha-esqueceu-senha',
            ['token' => $token]
        );
        
        //Enviar e-mail
        $mailer = new \Swift_Mailer($this->swiftTransport);
        $bodyMessage = 
                'Segue o link para definir nova senha:
                <a href="'.$url.'">'.$url.'</a><br />
                O prazo para definir nova senha é 24 horas';
        $message = (new \Swift_Message('Recuperar Senha'))
            ->setFrom(['example@example.org' => 'Example Company'])
            ->setTo([$email => $usrName])
            ->setBody($bodyMessage, 'text/html');
        $result = $mailer->send($message);
        if(!$result) {
            $urlErrorEmail = new ParameterURL($goToError);
            $urlErrorEmail->add('mensagens', 11);
            return $response->withRedirect($urlErrorEmail->returnUrl());
        }

        //Redirecionar para pagina de login com mensagem de sucesso
        $goTo = $this->router->pathFor('login');
        $url = new ParameterURL($goTo);
        $url->add('mensagens', 10);
        return $response->withRedirect($url->returnUrl());
    }

    /**
     * Controller de página de trocar senha
     * @todo Implementar formulário...
     *
     * @param Request $request
     * @param Response $response
     * @param Array $args
     * @return void
     */
    public function novaSenhaEsqueceuSenha(Request $request, Response $response, Array $args)
    {
        return $response->write('Trocar senha');
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