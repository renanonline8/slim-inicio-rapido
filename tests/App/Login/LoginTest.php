<?php
namespace App\Login;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Login\LoginSite;

class LoginTest extends TestCase
{
    protected function setUp()
    {
        $ini = new \Utils\LeitorINI\LeitorINI(__DIR__ . "/../../../app.ini");
        \ActiveRecord\Config::initialize(function($cfg) use ($ini) {
            $cfg->set_model_directory(__DIR__ . '/../../../src/App/Models');
            $cfg->set_connections(
                array(
                    'development' => $ini->retornaVariaveis()['bd_active_record']['development']
                )
            );
        });
    }

    public function testLogar()
    {
        $usuario = 'renanonline8@gmail.com';
        $senha = 'ad23ol12';

        $login = new LoginSite($usuario, $senha);
        $usuarioObj = $login->logar();

        $esperado = array(
            'login' => true,
            'dados' => array (
                'id' => 'XYZ',
                'email' => 'renanonline8@gmail.com'
            )
        );
        
        $atual = $usuarioObj->retornaDados();

        $this->assertEquals($esperado, $atual);
    }
}