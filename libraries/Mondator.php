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
 * Mondator wrapper
 * @package mongator
 */
class Mondator
{
    private $CI;

    private $mondator;

    public function __construct()
    {
        log_message('debug', 'Mondator Class Initialized');

        $this->CI = get_instance();
        $this->CI->load->config('mongator');
    }

    public function __call($method, $arguments)
    {
        return call_user_func_array(
            array($this->getMondator(), $method),
            $arguments
        );
    }

    private function getMondator()
    {
        if ( $this->mondator ) return $this->mondator;

        $this->mondator = new Mandango\Mondator\Mondator();
        $this->mondator->setExtensions(array(
            new Mongator\Extension\Core(array(
                'metadata_factory_class'  => $this->getConfig('mongator_metadata_class'),
                'metadata_factory_output' => $this->getConfig('mongator_models_output'),
                'default_output'          => $this->getConfig('mongator_models_output'),
            ))
        ));

        return $this->mondator;
    }

    private function getConfig($key)
    {
        if ( $config = $this->CI->config->item($key) ) return $config;
        return false;
    }
}
