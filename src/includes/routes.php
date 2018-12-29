<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \App\Middleware\SessaoNormalMid;
use \App\Middleware\MensagemMid;

$app->add(new MensagemMid($container));

$app->get('/tests/email', 'ControllerTest:sendEmail')->setName('test-email');

$app->get('/login', 'ControllerLogin:login')->setName('login');
$app->get('/login/cadastro', 'ControllerLogin:cadastro')->setName('login-cadastro');
$app->get('/login/esqueceu_senha', 'ControllerLogin:esqueceuSenha')->setName('login-esqueceu-senha');
$app->post('/login/esqueceu_senha/enviar', 'ControllerLogin:enviarEsqueceuSenha')->setName('enviar-esqueceu-senha');
$app->get('/login/esqueceu_senha/nova_senha/{token}', 'ControllerLogin:novaSenhaEsqueceuSenha')->setName('nova-senha-esqueceu-senha');
$app->post('/login/esqueceu_senha/nova_senha/validar', 'ControllerLogin:validaNovaSenha')->setName('valida-nova-senha');
$app->post('/login/entrar', 'ControllerLogin:entrar')->setName('entrar');
$app->post('/login/criar_usuario', 'ControllerLogin:criarUsuario')->setName('criar-usuario');
$app->get('/login/sair', 'ControllerLogin:sair')->setName('login-sair');

$app->group('', function () {
    $this->get('/dashboard', 'ControllerDashboard:dash')->setName('dashboard');
    $this->get('/usuario', 'ControllerUsuario:home')->setName('usuario-dados');
    $this->get('/usuario/form_alterar_dados/{id}', 'ControllerUsuario:formAlterarDados')->setName('usuario-form-alterar-dados');
    $this->post('/usuario/alterar_dados/{id}', 'ControllerUsuario:AlterarDados')->setName('usuario-alterar-dados');
    $this->get('/usuario/form_alterar_senha/{id}', 'ControllerUsuario:formAlterarSenha')->setName('usuario-form-alterar-senha');
    $this->post('/usuario/alterar_senha/{id}', 'ControllerUsuario:alterarSenha')->setName('usuario-alterar-senha');
    $this->get('/usuario/form_excluir_conta/{id}', 'ControllerUsuario:formExcluirConta')->setName('usuario-form-excluir');
    $this->post('/usuario/excluir_conta/{id}', 'ControllerUsuario:excluirConta')->setName('usuario-excluir');
    $this->get('/usuario/form_alterar_foto/{id}', 'ControllerUsuario:formAlterarFoto')->setName('usuario-form-alterar-foto');
    $this->post('/usuario/alterar_foto/{id}', 'ControllerUsuario:alterarFoto')->setName('usuario-alterar-foto');
})->add(new SessaoNormalMid($container));

