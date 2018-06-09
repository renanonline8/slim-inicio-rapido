<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/includes/config.php';

$app = new \Slim\App(['settings' => $config]);

$container = $app->getContainer();

require_once __DIR__ . '/../src/includes/container.php';

require_once __DIR__ . '/../src/includes/routes.php';

$app->run();

