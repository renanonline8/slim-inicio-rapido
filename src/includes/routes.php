<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Middleware\SessaoNormalMid;

$app->get('/login', 'ControllerLogin:login')->setName('login');
$app->get('/login/cadastro', 'ControllerLogin:cadastro')->setName('login-cadastro');
$app->get('/login/esqueceu_senha', 'ControllerLogin:esqueceuSenha')->setName('login-esqueceu-senha');
$app->post('/login/entrar', 'ControllerLogin:entrar')->setName('entrar');
$app->post('/login/criar_usuario', 'ControllerLogin:criarUsuario')->setName('criar-usuario');
$app->get('/login/sair', 'ControllerLogin:sair')->setName('login-sair');

$app->group('', function () {
    $this->get('/dashboard', 'ControllerDashboard:dash')
        ->setName('dashboard');
})->add(new SessaoNormalMid($container));