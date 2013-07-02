#!/usr/bin/env php
<?php
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'console');

require __DIR__ . '/../tests/Tests/Stubs.php';
require __DIR__ . '/../libraries/Mondator.php';
require __DIR__ . '/../libraries/Mongator.php';

$loader = require __DIR__ . '/../vendor/autoload.php';
$loader->add('Mongator\Codeigniter', __DIR__ );

use Symfony\Component\Console\Application;
use Mongator\Codeigniter\Command\IndexesCommand;
use Mongator\Codeigniter\Command\FixReferencesCommand;
use Mongator\Codeigniter\Command\GenerateCommand;

$file = file_get_contents(__DIR__ . '/../spark.info');
$spark = parse_ini_string(str_replace(':', '=', $file));

$console = new Application($spark['name'], $spark['version']);
$console->add(new GenerateCommand());
$console->add(new FixReferencesCommand());
$console->add(new IndexesCommand());

$console->run();
