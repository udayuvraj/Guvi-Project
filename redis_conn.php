<?php
require 'predis/autoload.php';
try{
    Predis\Autoloader::register();
    $redis = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => '127.0.0.1',
        'port'   => 6379,
    ]);
}
catch(Exception $e){
    die($e->getMessage());
}
?>