<?php
namespace Utils\URLs;

/**
 * Adiciona parametros a URL
 */
class ParameterURL
{
    /**
     * Rota de destino
     *
     * @var String
     */
    private $route;

    /**
     * Array dos parâmetros
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Construtor
     *
     * @param string $route
     */
    function __construct(String $route)
    {
        $this->route = $route;
    }

    /**
     * Adiciona um valor a um parâmetro
     *
     * @param String $parameter
     * @param String $value
     * @return void
     */
    function add(String $parameter, String $value)
    {
        if (empty($this->parameters[$parameter])) {
            $this->parameters[$parameter] = [$value];
        } else {
            array_push($this->parameters[$parameter], $value);
        }
    }

    /**
     * Retorna URL com parâmetros
     *
     * @return String
     */
    function returnUrl():String 
    {
        if (empty($this->parameters)) {
            throw new Exception("Não há parametros adicionados", 1);
        }
        
        $parameterUrl = '?';

        foreach ($this->parameters as $key => $value) {
            if(empty($value)) {
                break;
            }
            $parameterUrl .= '&' . $key . '=';
            $parameterUrl .= implode('%', $value);
        }

        return $this->route . $parameterUrl;
    }
}