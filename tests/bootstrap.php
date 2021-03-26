<?php

require dirname(__DIR__) . '/vendor/autoload.php';

if (file_exists(dirname(__DIR__) . '/config/bootstrap.php')) {
    require dirname(__DIR__) . '/config/bootstrap.php';
}
// Renvoi toujours false
// elseif (method_exists(Dotenv::class, 'bootEnv')) {
//    (new Dotenv())->bootEnv(dirname(__DIR__) . '/.env');
// }
