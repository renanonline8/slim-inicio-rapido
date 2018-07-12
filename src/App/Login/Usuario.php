<?php
namespace App\Login;

final class Usuario
{
    private $login;
    private $dados;

    public function __set($prop, $valor)
    {
        $this->dados[$prop] = $valor;
    }

    public function __get($prop)
    {
        if (isset($this->dados[$prop])) {
            return $this->dados[$prop];
        } else {
            return null;
        }
    }

    public function defineLogin($login)
    {
        $this->login = $login;
    }

    public function obtemLogin()
    {
        return $this->login;
    }

    public function retornaDados()
    {
        return array(
            'login' => $this->login,
            'dados' => $this->dados
        );
    }
}