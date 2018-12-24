<?php
$configIni = parse_ini_file(__DIR__ . "/../../app.ini", true);

\ActiveRecord\Config::initialize(function($cfg) use ($configIni) {
    $cfg->set_model_directory(__DIR__ . '/../App/Models');
    $cfg->set_connections(
        array(
            'development' => $configIni['bd_active_record']['development']
        )
    );
});