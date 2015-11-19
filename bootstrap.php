<?php

require dirname(__FILE__) . '/vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__FILE__));
$dotenv->load();
$dotenv->required([ 'XBOX_SITE_ENDPOINT', ])->notEmpty();

ini_set('date.timezone', getenv('DEFAULT_TIMEZONE'));