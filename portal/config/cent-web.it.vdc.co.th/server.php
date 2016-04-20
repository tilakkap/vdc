<?php

$config['components']['db'] = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=10.200.0.12;dbname=portal',
    'username' => 'portal',
    'password' => 'portal',
    'charset' => 'utf8',
    'enableSchemaCache' => true,

    // Duration of schema cache.
    'schemaCacheDuration' => 3600,

    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
];

$config['components']['db1'] = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=10.200.0.12;dbname=feeltop',
    'username' => 'vdcsysro',
    'password' => '#swimSea4',
    'charset' => 'utf8',
    'enableSchemaCache' => true,

    // Duration of schema cache.
    'schemaCacheDuration' => 3600,

    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
];

$config['components']['db2'] = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=cent-db;dbname=ajapp_db',
    'username' => 'ajapp_db',  //ajuser
    'password' => 'aj809124',  //fastZeal15
    'charset' => 'utf8',
    'enableSchemaCache' => true,

    // Duration of schema cache.
    'schemaCacheDuration' => 3600,

    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
];