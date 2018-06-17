<?php
namespace App\Login;

use App\Login\Usuario;
use App\Login\InterfaceLogin;

final class LoginSite implements InterfaceLogin
{
    private $login;
    private $senha;

    public function __construct($login, $senha)
    {
        $this->login = $login;
        $this->senha = $senha;
    }

    public function logar(): Usuario
    {
        $usuario = new Usuario();
        $usuario->defineLogin(true);
        $usuario->defineEmail('renanonline8@gmail.com');
        $usuario->defineId('XYZ');
        return $usuario;
    }
}