<?php
namespace App\CSRF;

use \Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Gera array para CSRF
 */
class ArrayCSRF
{
    /**
     * Guarda o array do csrf
     *
     * @var Array
     */
    private $csrf;

    /**
     * Constroi o array do CSRF
     *
     * @param String $nameKey Obter getTokenNameKey do container csrf
     * @param String $valueKey Obter getTokenValueKey do container csrf
     * @param Request $request
     */
    function __construct(String $nameKey, String $valueKey, Request $request) {
        $this->csrf = [
            'nameKey' => $nameKey,
            'valueKey' => $valueKey,
            'name' => $request->getAttribute($nameKey),
            'value' => $request->getAttribute($valueKey)
        ];
    }

    /**
     * Retorna o array do CSRF
     *
     * @return Array
     */
    function getCSRF(): Array
    {
        return $this->csrf;
    }
}