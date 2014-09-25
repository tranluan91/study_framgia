<?php

error_reporting(E_ALL);

try {
    /**
     *  Directory Path Definition
     */
    define('SYSTEM_ROOT', __DIR__.'/../');
    define('PUBLIC_PATH', __DIR__);
    define('APPS_PATH', SYSTEM_ROOT . 'app/');
    define('LIBS_PATH', SYSTEM_ROOT . 'libs/');

    /**
     * Read the configuration
     */
    $config = include APPS_PATH . "config/config.php";

    /**
     * Read auto-loader
     */
    include APPS_PATH . "config/loader.php";
    require LIBS_PATH . 'basics.php';

    /**
     * Include composer autoloader
     */
    require_once __DIR__ . "/vendor/autoload.php";

    /**
     * Read services
     */
    include APPS_PATH . "config/services.php";


    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle()->getContent();

} catch (\Exception $e) {
    echo $e->getMessage();
}
