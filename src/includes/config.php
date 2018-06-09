<?php

$config['displayErrorDetails'] = true;

\ActiveRecord\Config::initialize(function($cfg) {
    $cfg->set_model_directory(__DIR__ . '/../app/models');
    $cfg->set_connections(
        array(
            'development' => 'mysql://inicioSlim:ad23ol12@localhost/slim_inicio_rapido'
        )
    );
});