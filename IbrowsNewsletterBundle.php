<?php

namespace Ibrows\Bundle\NewsletterBundle;

use Ibrows\Bundle\NewsletterBundle\Security\MandantAuthenticationFactory;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class IbrowsNewsletterBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new BlockProviderCompilerPass());
        $container->addCompilerPass(new BlockRendererCompilerPass());
        
        	$extension = $container->getExtension('security');
        	$extension->addSecurityListenerFactory(new MandantAuthenticationFactory());
    }
}
