<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\Container;

class AnnotationDriver
{

    protected $container;
    protected $reader;
    
    protected $annotations = array();
    
    public function __construct(Container $container, array $annotations)
    {
        $this->container = $container;
        $this->reader = $container->get('annotation_reader');
        
        $this->annotations = $annotations;
    }
    
    public function onKernelController(FilterControllerEvent $event)
    {        
        $controllerArray = $event->getController();
        if(!is_array($controllerArray)){
            return;
        }
        
        $controller = $controllerArray[0];
        $methodName = $controllerArray[1];
        
        $controllerReflection = new \ReflectionClass($controller);
        $annotations = $this->getMethodAnnotations($controllerReflection, $methodName);
        
        foreach($this->annotations as $annotationKey => $annotationInfos){
            $handlerAnnotations = array_key_exists($annotationKey, $annotations) ? 
                $annotations[$annotationKey] : array();
            
            $annotationHandlerService = $this->container->get($annotationInfos['handler']);
            $annotationHandlerService->handle($event, $handlerAnnotations);
        }
    }
    
    protected function getMethodAnnotations(\ReflectionClass $controller, $currentMethodName)
    {
        $annotations = array();
        
        foreach($controller->getMethods() as $methodReflection){
            foreach($this->annotations as $annotationKey => $annotationInfos){
                $annotation = $this->reader->getMethodAnnotation($methodReflection, $annotationInfos['annotation']);
                if($annotation){
                    if($methodReflection->getName() == $currentMethodName){
                        $annotation->setIsCurrentMethod(true);
                    }
                    
                    $allAnnotations = array();
                    foreach($this->reader->getMethodAnnotations($methodReflection) as $allAnnotation){
                        $allAnnotations[get_class($allAnnotation)] = $allAnnotation;

                    }
                    
                    $annotations[$annotationKey][] = array(
                        'handler' => $annotation,
                        'all' => $allAnnotations
                    );
                }
            }
        }
        
        return $annotations;
    }
}