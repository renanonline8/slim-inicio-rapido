<?php
namespace App\Login;

use App\Login\Usuario;
use App\Login\InterfaceLogin;
use App\Models\Usuario as ModelUsuario;
use Exception;

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
        if (!$this->consultaUsuario() || !$this->verificarSenha()) {
            throw new Exception("Login ou senha inválidos", "1");
        }
        
        $modelUsuario = ModelUsuario::find_by_email($this->login);
        
        $usuario = new Usuario();
        $usuario->defineLogin(true);
        $usuario->email = $modelUsuario->email;
        $usuario->id = $modelUsuario->id_externo;
        return $usuario;
    }
    
    public function consultaUsuario()
    {
        $usuario = ModelUsuario::find_by_email($this->login);
        
        if(empty($usuario)) {
            return false;                
        }
        
        return true;
    }
    
    public function verificarSenha()
    {
        $usuario = ModelUsuario::find_by_email($this->login);
        
        if(!password_verify($this->senha, $usuario->senha)) {
            return false;
        }
        
        return true;
    }
}