<?php
namespace App\Validacao;

final class ValidacaoRedireciona
{
    private $urlErro;
    private $erros = Array();
    
    public function __construct(String $urlErro)
    {
        //$this->response = $response;
        $this->urlErro = $urlErro;
    }
    
    public function adicionaRegra(Bool $condicao, Int $codMsg)
    {
        if (!$condicao) {
            array_push($this->erros, $codMsg);
        }
        
        return $condicao;
    }
    
    public function retornaURLErros()
    {
        if (!empty($this->erros) ) {
            $mensagens = implode('%', $this->erros);
            $url = $this->urlErro . '?mensagens=' . $mensagens;
            return $url;
        }
        
        return null;
    }
    
    public function valida() {
        if (empty($this->erros)) {
            return true;
        }
        return false;
    }
}