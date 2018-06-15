<?php
namespace Utils\LeitorINI;

/**
 * Lê um arquivo ini e retorna um array com as variaveis do ini
 * 
 */
final class LeitorINI
{
    private $ini;
    
    public function __construct(String $caminho)
    {
        $this->ini = parse_ini_file($caminho, true);
    }
    
    public function retornaVariaveis(): Array
    {
        return $this->ini;
    }
}