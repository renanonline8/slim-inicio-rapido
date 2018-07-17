<?php
namespace App\Controller;

use Utils\Controller\Controller;
use Utils\TwigUtils\TwigInputs;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Models\Usuario;
use Respect\Validation\Validator as v;
use App\Validacao\ValidacaoRedireciona;

final class ControllerUsuario extends Controller
{
    public function home(Request $request, Response $response, Array $args)
    {
        $this->twigArgs->adcDados('usuario', $this->obterDadosUsuario());
        return $this->view->render($response, 'usuario-dados.twig', $this->twigArgs->retArgs());
    }
    
    public function formAlterarDados(Request $request, Response $response, Array $args)
    {
        $this->twigArgs->adcDados('usuario', $this->obterDadosUsuario());
        return $this->view->render($response, 'usuario-alterar-dados.twig', $this->twigArgs->retArgs());
    }

    public function alterarDados(Request $request, Response $response, Array $args)
    {
        $usuario = Usuario::find_by_id_externo($args['id']);
        if (password_verify($request->getParam('senha'), $usuario->senha)) {
            $usuario->nome = $request->getParam('nome');
            $usuario->email = $request->getParam('email');
            $usuario->save();
            return $response->withRedirect($this->router->pathFor('usuario-dados') . '?mensagens=7');
        } else {
            $inputs = new TwigInputs();
            $inputs->registra($request->getParsedBody());
            return $response->withRedirect($this->router->pathFor(
                'usuario-form-alterar-dados', 
                array(
                    'id' => $args['id']
                )
            ) . '?mensagens=5');
        }
    }
    
    public function formAlterarSenha(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-senha.twig', $this->twigArgs->retArgs());
    }
    
    public function alterarSenha(Request $request, Response $response, Array $args)
    {
        $inputs = new \StdClass();
        $inputs->senhaAtual = $request->getParam('senhaAtual');
        $inputs->senhaNova = $request->getParam('senhaNova');
        $inputs->senhaNovaConfirma = $request->getParam('senhaNovaConfirma');

        $usuario = Usuario::find_by_id_externo($args['id']);

        $validacao = new ValidacaoRedireciona(
            $this->router->pathFor(
                'usuario-form-alterar-senha',
                array ('id' => $args['id'])
            )
        );
        
        $validacao->adicionaRegra(
            password_verify($inputs->senhaAtual, $usuario->senha),
            5
        );
        $validacao->adicionaRegra(
            v::equals($inputs->senhaNova)->validate($inputs->senhaNovaConfirma),
            8
        );
        
        if (!$validacao->valida()) {
            return $response->withRedirect($validacao->retornaURLErros());
        }

        // Hash de senha
        $senhaHash = \password_hash(
            $inputs->senhaNova,
            PASSWORD_DEFAULT,
            ['cost' == 12]
        );

        $usuario->senha = $senhaHash;
        $usuario->save();

        return $response->withRedirect(
            $this->router->pathFor(
                'usuario-dados'
            ) . '?mensagens=9'
        );
    }
    
    public function excluirConta(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-excluir.twig', $this->twigArgs->retArgs());
    }

    public function alterarFoto(Request $request, Response $response, Array $args)
    {
        return $this->view->render($response, 'usuario-alterar-foto.twig', $this->twigArgs->retArgs());
    }

    private function obterDadosUsuario() {
        $dadosSessao = $this->twigArgs->retArgs('sessao');
        $usuario = Usuario::find_by_id_externo($dadosSessao['id']);
        return $usuario->to_array(array(
            'except' => 'senha'
        ));
    }
}