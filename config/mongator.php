<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MongoDB Connection DSN
|--------------------------------------------------------------------------
|
| MongoDB server connection string
|
| http://es1.php.net/manual/es/mongoclient.construct.php
|
*/

$config['mongator_connection_dsn'] = 'mongodb://localhost:27017';

/*
|--------------------------------------------------------------------------
| MongoDB Database name
|--------------------------------------------------------------------------
|
| MongoDB database name
|
| http://es1.php.net/manual/en/mongoclient.selectdb.php
|
*/

$config['mongator_connection_database'] = 'database';

/*
|--------------------------------------------------------------------------
| Connection name
|--------------------------------------------------------------------------
|
| Mongator Connection name, just for connection recognition
|
| http://es1.php.net/manual/en/mongoclient.selectdb.php
|
*/

$config['mongator_connection_name'] = 'default';

/*
|--------------------------------------------------------------------------
| Mongator Models input path
|--------------------------------------------------------------------------
|
| The input path of the classes, A valid dir with YAML definitions of the
| config classes, you must save the YAMLs config classes in this path.
|
*/

$config['mongator_models_input'] = __DIR__ . '/../input/';

/*
|--------------------------------------------------------------------------
| Models namespace
|--------------------------------------------------------------------------
|
| The output path of the classes.
| Example:
| If you models are call 'MyApp\Models\Article' you must set this as 'MyApp'
|
*/

$config['mongator_models_namespace'] = 'Model';

/*
|--------------------------------------------------------------------------
| Metadata class name
|--------------------------------------------------------------------------
|
| The metadata factory class name, just change it if you know what are you
| doing.
|
*/

$config['mongator_metadata_class'] = 'Model\Mapping\Metadata';

/*
|--------------------------------------------------------------------------
| Mongator Models output path
|--------------------------------------------------------------------------
|
| The output path of the classes, just change it if you know what are you
| doing.
|
*/

$config['mongator_models_output'] = __DIR__ . '/../output/';
