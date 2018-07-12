<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Middleware\SessaoNormalMid;
use \App\Middleware\MensagemMid;

$app->add(new MensagemMid($container));

$app->get('/login', 'ControllerLogin:login')->setName('login');
$app->get('/login/cadastro', 'ControllerLogin:cadastro')->setName('login-cadastro');
$app->get('/login/esqueceu_senha', 'ControllerLogin:esqueceuSenha')->setName('login-esqueceu-senha');
$app->post('/login/entrar', 'ControllerLogin:entrar')->setName('entrar');
$app->post('/login/criar_usuario', 'ControllerLogin:criarUsuario')->setName('criar-usuario');
$app->get('/login/sair', 'ControllerLogin:sair')->setName('login-sair');

$app->group('', function () {
    $this->get('/dashboard', 'ControllerDashboard:dash')->setName('dashboard');
    $this->get('/usuario', 'ControllerUsuario:home')->setName('usuario-dados');
    $this->get('/usuario/alterar_email/{id}', 'ControllerUsuario:alterarEmail')->setName('usuario-email');
    $this->get('/usuario/alterar_senha/{id}', 'ControllerUsuario:alterarSenha')->setName('usuario-senha');
    $this->get('/usuario/excluir_conta/{id}', 'ControllerUsuario:excluirConta')->setName('usuario-excluir');
})->add(new SessaoNormalMid($container));