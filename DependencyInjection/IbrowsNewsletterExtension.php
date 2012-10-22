<?php

namespace Ibrows\Bundle\NewsletterBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class IbrowsNewsletterExtension extends Extension
{
	public function load(array $configs, ContainerBuilder $container)
	{
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
		$loader = new XmlFileLoader(
            $container, 
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        
		$loader->load('services.xml');
		
		if('custom' !== $config['db_driver']){
			$loader->load(sprintf('services.%s.xml', $config['db_driver']));
		}
        
        $config['blockcomposition'] = array_merge($config['defaultblockcomposition'], $config['blockcomposition']);
        unset($config['defaultblockcomposition']);
        
        $config['blockprovider'] = array_merge($config['defaultblockprovider'], $config['blockprovider']);
        unset($config['defaultblockprovider']);
        
        $config['blockrenderer'] = array_merge($config['defaultblockrenderer'], $config['blockrenderer']);
        unset($config['defaultblockrenderer']);
        
		$this->registerContainerParametersRecursive($container, $this->getAlias(), $config);
	}

	protected function registerContainerParametersRecursive(ContainerBuilder $container, $alias, $config)
	{
		$iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($config),
            \RecursiveIteratorIterator::SELF_FIRST);
		
		foreach ($iterator as $value) {
			$path = array( );
			for($i = 0; $i <= $iterator->getDepth(); $i++){
				$path[] = $iterator->getSubIterator($i)->key();
			}
			$key = $alias . '.' . implode(".", $path);
			$container->setParameter($key, $value);
		}
	}
}
