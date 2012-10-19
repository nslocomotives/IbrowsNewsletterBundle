<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation\WizardAction;

use Ibrows\Bundle\NewsletterBundle\Annotation\AnnotationHandlerInterface;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class WizardActionAnnotationHandler implements AnnotationHandlerInterface
{
    protected $router;
    protected $validation;
    protected $annotations = array();
    protected $currentAnnotationKey;
    
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    public function handle(FilterControllerEvent $event, array $annotations = array()){
        $controllerArray = $event->getController();
        $controller = $controllerArray[0];
        
        usort($annotations, function($a, $b){
            return $a['handler']->number > $b['handler']->number;
        });
        
        $this->annotations = $annotations;
        
        $defaultValidation = true;
        
        /* @var $annotation WizardActionAnnotation */
        foreach($annotations as $key => $annotationArray){
            $annotation = $annotationArray['handler'];
            
            $validationMethodName = $annotation->validationMethod;
            $validation = $controller->$validationMethodName();
            
            if($validation instanceof Response){
                $defaultValidation = $validation;
            }
            
            if(true === $annotation->isCurrentMethod()){
                $this->currentAnnotationKey = $key;
                break;
            }
        }
        
        $this->validation = $defaultValidation;
    }
    
    /**
     * @return true|Response
     */
    public function getValidation()
    {
        return $this->validation;
    }
    
    public function getNextStepUrl()
    {
        $key = $this->currentAnnotationKey+1;
        
        if(array_key_exists($key, $this->annotations)){
            return $this->getRoute($this->annotations[$key]);
        }
        
        throw new \InvalidArgumentException("No route found");
    }
    
    public function getPrevStepUrl()
    {
        $key = $this->currentAnnotationKey-1;
        
        if(array_key_exists($key, $this->annotations)){
            return $this->getRoute($this->annotations[$key]);
        }
        
        throw new \InvalidArgumentException("No route found");
    }
    
    protected function getRoute(array $annotation)
    {
        foreach($annotation['all'] as $annotation){
            if($annotation instanceof Route){
                return $this->router->generate($annotation->getName());
            }
        }
        
        throw new \InvalidArgumentException("No route found");
    }
}