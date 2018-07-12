<?php
namespace Utils\Mensagem;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use Utils\Mensagem\Mensagem;

class MensagemTest extends TestCase
{
    public function testCriarMensagem()
    {
        $mensagem = new Mensagem(1);
        $atual = $mensagem->serialize();

        $esperado = array(
            'codigo' => 1,
            'tipo' => 'aviso',
            'mensagem' => 'Teste'
        );

        $this->assertEquals($esperado, $atual);
    }

    public function testErroIndefinido()
    {
        $mensagem = new Mensagem(0);
        $atual = $mensagem->serialize();

        $esperado = array(
            'codigo' => 99999,
            'tipo' => 'desconhecido',
            'mensagem' => 'Mensagem desconhecida'
        );

        $this->assertEquals($esperado, $atual);
    }
}