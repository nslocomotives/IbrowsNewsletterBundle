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
        
		$loader = new XmlFileLoader($container,
				new FileLocator(__DIR__ . '/../Resources/config'));
		$loader->load('services.xml');

		$this	->registerContainerParameters($container, $this->getAlias(), $config);
	}

	protected function registerContainerParameters(ContainerBuilder $container,	$alias, $config)
	{
		$iterator = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($config),
				\RecursiveIteratorIterator::SELF_FIRST);
		
		foreach ($iterator as $value) {
			if ($iterator->hasChildren()) {
				continue;
			}
			$path = array( );
			for ($i = 0; $i <= $iterator->getDepth(); $i++) {
				$path[] = $iterator->getSubIterator($i)->key();
			}
			$container->setParameter($alias . '.' . implode(".", $path), $value);
		}
	}
}
