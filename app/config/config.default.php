<?php

return new \Phalcon\Config(array(
    'database' => array(
        'adapter'     => 'Mysql',
        'host'        => 'your host',
        'username'    => 'your user name',
        'password'    => 'password',
        'dbname'      => 'dbname',
    ),
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/',
        'app' => array(
            'servicesDir' => __DIR__ . '/../../services/',
        ),
        'layoutsDir'     => __DIR__ . '/../../app/views/layouts/',
    ),
    'facebook'  => array(
        'appId' => '1519901488224583',
       'secret' => '966dbe45921a76e7424db5389da2840f',
       'scope'  => 'public_profile,email'
    ),
    'database_redis' => array(
        'host' => 'localhost',
        'port' => '6379',
        'database_number' => 1,
    ),
));
