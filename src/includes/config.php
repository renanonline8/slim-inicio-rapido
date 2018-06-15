<?php

$appIni = parse_ini_file(__DIR__ . "/../../app.ini", true);

$config['displayErrorDetails'] = true;

\ActiveRecord\Config::initialize(function($cfg) use ($appIni) {
    $cfg->set_model_directory(__DIR__ . '/../App/Models');
    $cfg->set_connections(
        array(
            'development' => $appIni['bd_active_record']['development']
        )
    );
});