<?php

$container['ControllerLogin'] = function($c) {
    return new \App\Controller\ControllerLogin($c);
};

$container['ControllerDashboard'] = function($c) {
    return new \App\Controller\ControllerDashboard($c);
};