<?php

namespace Ibrows\Bundle\NewsletterBundle\DependencyInjection;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

	public function getConfigTreeBuilder()
	{
		$treeBuilder = new TreeBuilder();
		$rootNode = $treeBuilder->root('ibrows_newsletter');

		$rootNode
			->addDefaultsIfNotSet()->children()
			->scalarNode('db_driver')->defaultValue('orm')->end()
			->scalarNode('engine')->defaultValue('twig')->end()->end()
		;
		
		$this->addClassesSection($rootNode);

		return $treeBuilder;
	}
	
	public function addClassesSection(ArrayNodeDefinition $node)
	{
	}

}
