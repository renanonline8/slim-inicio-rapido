<?php

$container['twig'] = function($c) {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../templates');
    $twig = new Twig_Environment($loader);
    return $twig;
};

//Controllers
require_once __DIR__ . '/controllers.php';