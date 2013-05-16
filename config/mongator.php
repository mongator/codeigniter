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

$config['mongator_connection_database'] = '';

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
| Metadata class name
|--------------------------------------------------------------------------
|
| The metadata factory class name, just change it if you know what are you
| doing.  
|
*/

$config['mongator_metadata_class'] = 'Model\Mapping\Metadata';


/*
mongator_logger (default null): instance of a logger class
mongator_cache_fields (default ArrayCache): instance of a mongator cache driver used in fields cache
mongator_cache_data (default ArrayCache): instance of a mongator cache driver used in data cache
mongator_extensions (default Array()): array of extension instances
mongator_models_output: output path of the classes
mongator_classes_config (default Array()): The config classes contain the information of the classes
mongator_classes_yaml.path: A valid dir with YAML definitions of the config classes
*/