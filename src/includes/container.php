<?php
$container['twig'] = function($c) {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../templates');
    $twig = new Twig_Environment($loader);
    return $twig;
};

$container['ini'] = function($c) {
    $ini = new \Utils\LeitorINI\LeitorINI(__DIR__ . "/../../app.ini");
    return $ini;
};

\ActiveRecord\Config::initialize(function($cfg) use ($container) {
    $cfg->set_model_directory(__DIR__ . '/../App/Models');
    $cfg->set_connections(
        array(
            'development' => $container->ini->retornaVariaveis()['bd_active_record']['development']
        )
    );
});

//Controllers
require_once __DIR__ . '/controllers.php';