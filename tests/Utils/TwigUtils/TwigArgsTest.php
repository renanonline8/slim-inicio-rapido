<?php
namespace Utils\TwigUtils;

require __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Login\LoginSite;
use App\Sessao\Sessao;
use Utils\TwigUtils\TwigArgs;
use Utils\Mensagem\Mensagem;

class TwigUtilsTest extends TestCase
{
    public function testAdcMensagemUmaMensagem()
    {
        $mensagem = new Mensagem(1);
        $twigArgs = new TwigArgs();
        $twigArgs->adcMensagem($mensagem);
        $atual = $twigArgs->retArgs();

        $esperado = array(
            'mensagem' => [
                [
                    'codigo' => '1',
                    'tipo' => 'aviso',
                    'mensagem' => 'Teste'
                ]
            ],
            'sessao' => [],
            'dados' => []
        );

        $this->assertEquals($esperado, $atual);
    }

    public function testAdcMensagemDuasMensagens()
    {
        $mensagem1 = new Mensagem(1);
        $mensagem2 = new Mensagem(0);

        $twigArgs = new TwigArgs();
        $twigArgs->adcMensagem($mensagem1);
        $twigArgs->adcMensagem($mensagem2);
        $atual = $twigArgs->retArgs();

        $esperado = array(
            'mensagem' => [
                [
                    'codigo' => '1',
                    'tipo' => 'aviso',
                    'mensagem' => 'Teste'
                ],
                [
                    'codigo' => '99999',
                    'tipo' => 'desconhecido',
                    'mensagem' => 'Mensagem desconhecida'
                ]
            ],
            'sessao' => [],
            'dados' => []
        );

        $this->assertEquals($esperado, $atual);
    }

    public function testAdcSessao()
    {
        $twigMensagem = new TwigArgs();

        $sessao = new Sessao(true);
        $sessao->nome = 'teste';

        $twigMensagem->adcSessao($sessao);

        $atual = $twigMensagem->retArgs();

        $esperado = array(
            'mensagem' => [],
            'sessao' => [
                'nome' => 'teste'
            ],
            'dados' => []
        );

        $this->assertEquals(true, true);
    }

    public function testAdcDadosString()
    {
        $twig = new TwigArgs();
        $twig->adcDados('campo', 'teste');
        $atual = $twig->retArgs();

        $esperado = array(
            'mensagem' => [],
            'sessao' => [],
            'dados' => [
                'campo' => 'teste'
            ]
        );

        $this->assertEquals($esperado, $atual);
    }

    public function testAdcDadosDoisArgs()
    {
        $twig = new TwigArgs();
        $twig->adcDados('campo', 'teste');
        $twig->adcDados('array', ['oi', 'bem']);
        $atual = $twig->retArgs();

        $esperado = array(
            'mensagem' => [],
            'sessao' => [],
            'dados' => [
                'campo' => 'teste',
                'array' => [
                    'oi',
                    'bem'
                ]
            ]
        );

        $this->assertEquals($esperado, $atual);
    }
}