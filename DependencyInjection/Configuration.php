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
			->addDefaultsIfNotSet()
				->children()
					->scalarNode('db_driver')->defaultValue('orm')->end()
				->end()
		;
		
		$this->addTemplatesSection($rootNode);
		$this->addClassesSection($rootNode);
        $this->addBlockProviderSection($rootNode);
        $this->addBlockRendererSection($rootNode);
        $this->addBlockCompositionSection($rootNode);

		return $treeBuilder;
	}
	
	public function addTemplatesSection(ArrayNodeDefinition $node)
	{
		$node
			->children()
				->arrayNode('templates')
					->addDefaultsIfNotSet()
					->children()
						->scalarNode('base_template')->defaultValue('IbrowsNewsletterBundle::layout.html.twig')->end()
						->arrayNode('mandant')
							->addDefaultsIfNotSet()
							->children()
								->scalarNode('index')->defaultValue('IbrowsNewsletterBundle:Mandant:index.html.twig')->end()
								->scalarNode('edit')->defaultValue('IbrowsNewsletterBundle:Mandant:edit.html.twig')->end()
							->end()
						->end()
						->arrayNode('newsletter')
							->addDefaultsIfNotSet()
							->children()
								->scalarNode('index')->defaultValue('IbrowsNewsletterBundle:Newsletter:index.html.twig')->end()
                                ->scalarNode('create')->defaultValue('IbrowsNewsletterBundle:Newsletter:create.html.twig')->end()
								->scalarNode('edit')->defaultValue('IbrowsNewsletterBundle:Newsletter:edit.html.twig')->end()
								->scalarNode('subscriber')->defaultValue('IbrowsNewsletterBundle:Newsletter:subscriber.html.twig')->end()
								->scalarNode('summary')->defaultValue('IbrowsNewsletterBundle:Newsletter:summary.html.twig')->end()
                                ->scalarNode('send')->defaultValue('IbrowsNewsletterBundle:Newsletter:send.html.twig')->end()
							->end()
						->end()
					->end()
				->end()
			->end()
		;
	}
	
	public function addClassesSection(ArrayNodeDefinition $node)
	{
		$node->children()
				->arrayNode('classes')->children()
						->arrayNode('model')
							->children()
								->scalarNode('newsletter')->isRequired()->cannotBeEmpty()->end()
								->scalarNode('mandant')->isRequired()->cannotBeEmpty()->end()
								->scalarNode('subscriber')->isRequired()->cannotBeEmpty()->end()
							->end()
						->end()
						->arrayNode('form')
							->addDefaultsIfNotSet()
							->children()
								->scalarNode('newsletter_meta')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Form\\NewsletterMetaType')->end()
								->scalarNode('newsletter_content')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Form\\NewsletterContentType')->end()
								->scalarNode('subscriber')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Form\\SubscriberType')->end()
							->end()
						->end()
				->end()
			->end()
		;
	}
    
    public function addBlockCompositionSection(ArrayNodeDefinition $node)
	{           
		$node->children()
                ->arrayNode('defaultblockcomposition')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('TextAndImage')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Entity\\Block\\Composition\\TextAndImageComposition')->end()
                    ->end()
                ->end()
                ->arrayNode('blockcomposition')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
			->end()
		;
	}
    
    public function addBlockRendererSection(ArrayNodeDefinition $node)
	{           
		$node->children()
                ->arrayNode('defaultblockrenderer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('Null')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Model\\Block\\Renderer\\NullRenderer')->end()
                    ->end()
                ->end()
                ->arrayNode('blockrenderer')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
			->end()
		;
	}
    
    public function addBlockProviderSection(ArrayNodeDefinition $node)
	{           
		$node->children()
                ->arrayNode('defaultblockprovider')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('Image')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Model\\Block\\Provider\\ImageProvider')->end()
                        ->scalarNode('TextArea')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Model\\Block\\Provider\\TextAreaProvider')->end()
                    ->end()
                ->end()
                ->arrayNode('blockprovider')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
			->end()
		;
	}
    
}