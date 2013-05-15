<?php
/*
 * This file is part of the Skeetr package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$loader = require __DIR__.'/../vendor/autoload.php';


/**
 * Mongator wrapper
 * @package mongator
 */

require_once APPPATH.'third_party/xapian.php';

/*

mongator_connection_dsn (default 'mongodb://localhost:27017'): database connection string
mongator_connection_database: the database name
mongator_connection_name (default 'default'): the name of the connection

mongator_metadata_class (default 'Model\Mapping\Metadata'): The metadata factory class name
mongator_logger (default null): instance of a logger class

mongator_cache_fields (default ArrayCache): instance of a mongator cache driver used in fields cache
mongator_cache_data (default ArrayCache): instance of a mongator cache driver used in data cache
mongator_extensions (default Array()): array of extension instances
mongator_models_output: output path of the classes
mongator_classes_config (default Array()): The config classes contain the information of the classes
mongator_classes_yaml.path: A valid dir with YAML definitions of the config classes

 */

class YuXapian {
    private $CI;

    private $mongator;
    private $metadata;
    private $logger;
    private $fieldsCache;
    private $dataCache;
    private $connection;
    private $config;

    public function __construct(){
        $this->CI = &get_instance();
        
        $this->config = array(
            'mongator_connection_dsn' => 'mongodb://localhost:27017',
            'mongator_connection_name' => 'default',
        );
    }

    private function getMongator() {
        if ( $this->mongator ) return $this->mongator;

        $this->mongator = new Mongator($this->getMetadata());

        $this->mongator->setFieldsCache($this->getFieldsCache());
        $this->mongator->setDataCache($this->getDataCache());
        $this->mongator->setConnection(
            $this->getConfig('mongator_connection_name'), 
            $this->getConnection()
        );    
        return $this->mongator;
    }

    private function getMetadata() {
        if ( $this->metadata ) return $this->metadata;

        if ( !class_exists($class = $this->getConfig('mongator_metadata_class')) ) {
            throw new \LogicException(
                'You must configure a valid "mongator_metadata_class" to this spark, maybe you forget to generate your models?'
            );
        }

        $this->metadata = new $class();
        return $this->metadata;
    }

    private function getFieldsCache() {
        if ( $this->fieldsCache ) return $this->fieldsCache;

        $this->fieldsCache = new ArrayCache();
        return $this->fieldsCache;
    }

    private function getDataCache() {
        if ( $this->dataCache ) return $this->dataCache;

        $this->dataCache = new ArrayCache();
        return $this->dataCache;
    }

    private function getConnection() {
        if ( $this->connection ) return $this->connection;

        if (!$dsn = $this->getConfig('mongator_connection_dsn')) {
            throw new \LogicException(
                'You must configure "mongator_connection_dsn" to this spark'
            );
        }
    
        if (!$database = $this->getConfig('mongator_connection_dsn')) {
            throw new \LogicException(
                'You must configure "mongator_connection_database" to this spark'
            );
        }

        $this->connection = new Connection($dsn, $database);
        return $this->connection;
    }

    private function getConfig($key) {
        if ( $config = $this->CI->config->item($key) ) return $config;
        if ( !isset($this->config[$key]) ) return false;
        return $this->config[$key];
    }
}