<?php
namespace Utils\Mensagem;

final class Mensagem
{
    private $mensagem;
    private $tipo;
    private $codigo;

    public function __construct(Int $codigo)
    {
        $json = file_get_contents(__DIR__ .  '/Mensagem.json');
        $array = json_decode($json, true);
        if (empty($array[$codigo])) {
            $this->codigo = 99999;
            $this->tipo = 'desconhecido';
            $this->mensagem = 'Mensagem desconhecida';
        } else {
            $this->codigo = $codigo;
            $this->tipo = $array[$codigo]['tipo'];
            $this->mensagem = $array[$codigo]['mensagem'];
        }
    }

    public function serialize(): Array
    {
        $array = array (
            'codigo' => $this->codigo,
            'tipo' => $this->tipo,
            'mensagem' => $this->mensagem
        );
        return $array;
    }
}