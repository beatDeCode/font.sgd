<?php

//QA Conexion


return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.0.213)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = SIRLFEDS.seguroslafe.com) (SID = SIRLFEDS.seguroslafe.com)))'),
        'host'           => env('DB_HOST', '192.168.0.213'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', 'gestiondata'),
        'password'       => env('DB_PASSWORD', 'gestiondesa'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];

/* QA Conexion Casa*/
/*
return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = xe) (SID = xe)))'),
        'host'           => env('DB_HOST', 'localhost'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', 'interface'),
        'password'       => env('DB_PASSWORD', 'prueba1'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];   
*/
//Prod Conexion

/*
return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.0.3)(PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = SIRLFEPR.seguroslafe.com) (SID = SIRLFEPR.seguroslafe.com)))'),
        'host'           => env('DB_HOST', '192.168.0.3'),
        'port'           => env('DB_PORT', '1521'),
        'database'       => env('DB_DATABASE', ''),
        'username'       => env('DB_USERNAME', 'gestiondata'),
        'password'       => env('DB_PASSWORD', 'gestion1234'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
        'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '11g'),
    ],
];*/