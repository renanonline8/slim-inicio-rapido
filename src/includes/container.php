<?php
$container['twig'] = function($c) {
    $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../templates');
    $twig = new Twig_Environment($loader);
    return $twig;
};

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ . '/../../templates');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));

    return $view;
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

$container['debugLog'] = function($c) use ($container) {
    $varsINI = $container->ini->retornaVariaveis();
    $caminho = __DIR__ . $varsINI['debug_log']['caminho'];
    $log = new Monolog\Logger('app');
    $log->pushHandler(
        new Monolog\Handler\StreamHandler($caminho, Monolog\Logger::DEBUG)
    );
    return $log;
};

//Controllers
require_once __DIR__ . '/controllers.php';