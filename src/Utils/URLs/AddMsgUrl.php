<?php
namespace Utils\URLs;

class AddMsgUrl
{
    private $route;
    private $parameters = [];

    function __construct($route)
    {
        $this->route = $route;
    }

    function add($parameter, $value)
    {
        if (empty($this->parameters[$parameter])) {
            $this->parameters[$parameter] = [$value];
        } else {
            array_push($this->parameters[$parameter], $value);
        }
    }

    function returnUrl(){
        return $this->parameters;
    }
}