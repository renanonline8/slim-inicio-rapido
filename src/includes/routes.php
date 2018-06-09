<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/login', 'ControllerLogin:login')->setName('login');
$app->get('/login/cadastro', 'ControllerLogin:cadastro')->setName('login-cadastro');
$app->get('/login/esqueceu_senha', 'ControllerLogin:esqueceuSenha')->setName('login-esqueceu-senha');
$app->post('/login/entrar', 'ControllerLogin:entrar')->setName('entrar');
$app->get('/dashboard', 'ControllerDashboard:dash')->setName('dashboard');