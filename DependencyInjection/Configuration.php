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
        $this->addBlockSection($rootNode);
        $this->addAnnotationsSection($rootNode);

		return $treeBuilder;
	}
	
	public function addTemplatesSection(ArrayNodeDefinition $node)
	{
		$node
			->children()
				->arrayNode('templates')
					->addDefaultsIfNotSet()
					->children()
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
								->scalarNode('edit')->defaultValue('IbrowsNewsletterBundle:Newsletter:edit.html.twig')->end()
								->scalarNode('create')->defaultValue('IbrowsNewsletterBundle:Newsletter:create.html.twig')->end()
								->scalarNode('send')->defaultValue('IbrowsNewsletterBundle:Newsletter:send.html.twig')->end()
								->scalarNode('summary')->defaultValue('IbrowsNewsletterBundle:Newsletter:summary.html.twig')->end()
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
    
    public function addBlockSection(ArrayNodeDefinition $node)
	{           
		$node->children()
                ->arrayNode('defaultblocks')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('TextBlock')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Entity\\Block\\TextBlock')->end()
                        ->scalarNode('TextAndImageBlock')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Entity\\Block\\TextAndImageBlock')->end()
                    ->end()
                ->end()
                ->arrayNode('blocks')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
			->end()
		;
	}
    
    public function addAnnotationsSection(ArrayNodeDefinition $node)
	{           
		$node->children()
                ->arrayNode('annotations')
                    ->cannotBeOverwritten()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('wizardAction')
                            ->cannotBeOverwritten()
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('annotation')->defaultValue('Ibrows\\Bundle\\NewsletterBundle\\Annotation\\WizardAction\\WizardActionAnnotation')->end()
                                ->scalarNode('handler')->defaultValue('ibrows_newsletter.annotation.handler.wizardaction')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
			->end()
		;
	}
}