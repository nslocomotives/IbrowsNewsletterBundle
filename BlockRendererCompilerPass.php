<?php

namespace Ibrows\Bundle\NewsletterBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class BlockRendererCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition('ibrows_newsletter.block_renderer_manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'ibrows_newsletter.block_renderer_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ibrows_newsletter.block.renderer'
        );
        
        foreach($taggedServices as $id => $attributes){
            $definition->addMethodCall(
                'addBlockRenderer',
                array($id, new Reference($id))
            );
        }
    }
}