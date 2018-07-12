<?php
namespace App\Login;

use App\Login\Usuario;

interface InterfaceLogin
{
    public function logar(): Usuario;
}