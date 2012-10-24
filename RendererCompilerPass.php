<?php

namespace Ibrows\Bundle\NewsletterBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class RendererCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if(!$container->hasDefinition('ibrows_newsletter.renderer_manager')) {
            return;
        }

        $definition = $container->getDefinition(
            'ibrows_newsletter.renderer_manager'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ibrows_newsletter.renderer'
        );
        
        foreach($taggedServices as $id => $attributes){
            $definition->addMethodCall(
                'addRenderer',
                array($id, new Reference($id))
            );
        }
    }
}