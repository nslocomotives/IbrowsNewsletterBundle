<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

interface AnnotationHandlerInterface
{
    public function handle(FilterControllerEvent $event, array $annotations = array());
}