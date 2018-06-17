<?php
namespace App\Login;

final class Usuario
{
    private $login;
    private $id;
    private $email;

    public function defineLogin($login)
    {
        $this->login = $login;
    }

    public function defineId($id)
    {
        $this->id = $id;
    }

    public function defineEmail($email)
    {
        $this->email = $email;
    }

    public function obtemLogin()
    {
        return $this->login;
    }

    public function obtemID()
    {
        return $this->id;
    }

    public function obtemEmail()
    {
        return $this->email;
    }

    public function retornaDados()
    {
        return array(
            'login' => $this->login,
            'id' => $this->id,
            'email' => $this->email
        );
    }
}