<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * This file is part of the Mongator package.
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
class Mongator
{
    private $CI;

    private $mongator;
    private $metadata;
    private $logger;
    private $fieldsCache;
    private $dataCache;
    private $connection;
    private $config;

    public function __construct()
    {
        log_message('debug', 'Mongator Class Initialized');

        $this->CI = get_instance();
        $this->CI->load->config('mongator');

        $this->loader = require __DIR__.'/../vendor/autoload.php';
        $this->loader->add(
             $this->getConfig('mongator_models_namespace'),
             $this->getConfig('mongator_models_output')
        );
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array(
            array($this->getMongator(), $method),
            $arguments
        );
    }

    private function getMongator()
    {
        if ( $this->mongator ) return $this->mongator;

        $this->mongator = new Mongator\Mongator($this->getMetadata(), $this->getLogger());

        $this->mongator->setFieldsCache($this->getFieldsCache());
        $this->mongator->setDataCache($this->getDataCache());
        $this->mongator->setConnection(
            $this->getConfig('mongator_connection_name'),
            $this->getConnection()
        );

        $this->mongator->setDefaultConnectionName($this->getConfig('mongator_connection_name'));

        return $this->mongator;
    }

    private function getMetadata()
    {
        if ( $this->metadata ) return $this->metadata;

        if ( !class_exists($class = $this->getConfig('mongator_metadata_class')) ) {
            throw new \LogicException(
                'You must configure a valid "mongator_metadata_class" to this spark, maybe you forget to generate your models?'
            );
        }

        $this->metadata = new $class();

        return $this->metadata;
    }

    private function getFieldsCache()
    {
        if ( $this->fieldsCache ) return $this->fieldsCache;

        $this->fieldsCache = new Mongator\Cache\ArrayCache();

        return $this->fieldsCache;
    }

    private function getDataCache()
    {
        if ( $this->dataCache ) return $this->dataCache;

        $this->dataCache = new Mongator\Cache\ArrayCache();

        return $this->dataCache;
    }

    private function getConnection()
    {
        if ( $this->connection ) return $this->connection;

        if (!$dsn = $this->getConfig('mongator_connection_dsn')) {
            throw new \LogicException(
                'You must configure "mongator_connection_dsn" to this spark'
            );
        }

        if (!$database = $this->getConfig('mongator_connection_database')) {
            throw new \LogicException(
                'You must configure "mongator_connection_database" to this spark'
            );
        }

        $this->connection = new Mongator\Connection($dsn, $database);

        return $this->connection;
    }

    private function getLogger()
    {
        if ( ENVIRONMENT != 'development' ) return null;

        if ( $this->logger ) return $this->logger;

        $querys = 0;
        $this->logger = function($call) use (&$querys) {
            if ( !isset($call['collection']) ) $call['collection'] = 'none';

            $msg = sprintf(
                '[mongator] %s@%s.%s in %d sec(s), #%d',
                $call['type'], $call['database'],
                $call['collection'], $call['time'], ++$querys
            );

            log_message('debug', $msg);
        };

        return $this->logger;
    }

    private function getConfig($key)
    {
        if ( $config = $this->CI->config->item($key) ) return $config;
        return false;
    }
}
