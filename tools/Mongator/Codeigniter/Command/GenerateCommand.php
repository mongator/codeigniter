<?php
/*
 * This file is part of the Mongator package.
 *
 * (c) Máximo Cuadros <maximo@yunait.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Mongator\Codeigniter\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('mongator:generate')
            ->setDescription('Process config classes and generate the files of the classes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ci = get_instance();
        $mondator = new \Mondator();

        $output->write('<info>Generating models... </info>', false);        
        
        
        if ( !$path = $ci->config->item('mongator_models_input') || !is_dir($path) ) {
            throw new \LogicException(
                'Configured "mongator_models_input" not is a valid path.'
            );
        }

        $mondator->setConfigClasses($this->readYAMLs($path));
        $mondator->process();

        $output->writeln('<comment>Done</comment>');
    }


    private function readYAMLs($paths)
    {
        if ( !is_array($paths) ) $paths = (array)$paths;

        $defs = array();
        foreach($paths as $path) {
            foreach ($this->findYAMLs($path . '/*.yaml') as $file) {
                $defs = array_merge($defs, yaml_parse(file_get_contents($file)));
            }
        }

        return $defs;
    }

    private function findYAMLs($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        
        foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR) as $dir) {
            $files = array_merge($files, $this->findYAMLs($dir.'/'.basename($pattern), $flags));
        }
        
        return $files;
    }
}