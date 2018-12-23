<?php

$container['ControllerLogin'] = function($c) {
    return new \App\Controller\ControllerLogin($c);
};

$container['ControllerDashboard'] = function($c) {
    return new \App\Controller\ControllerDashboard($c);
};

$container['ControllerUsuario'] = function($c) {
    return new \App\Controller\ControllerUsuario($c);
};

$container['ControllerTest'] = function($c) {
    return new \App\Controller\ControllerTest($c);
};