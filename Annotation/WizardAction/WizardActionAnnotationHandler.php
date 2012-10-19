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
            return $a['handler']->getNumber() > $b['handler']->getNumber();
        });
        
        $this->annotations = $annotations;
        
        $wizardValidation = true;
        $hasFoundCurrentMethod = false;
        $hasFoundError = false;
        
        /* @var $annotation WizardActionAnnotation */
        foreach($annotations as $key => $annotationArray){
            $annotation = $annotationArray['handler'];
            
            $validationMethodName = $annotation->getValidationMethod();
            $validation = $controller->$validationMethodName($this);
            
            if($validation instanceof Response){
                $hasFoundError = true;
            }
            
            if(!$wizardValidation instanceof Response && $validation instanceof Response && !$hasFoundCurrentMethod){
                $wizardValidation = $validation;
            }
            
            $isValid = ($hasFoundError OR $wizardValidation instanceof Response OR $validation instanceof Response) ? false : true;
            $annotation->setIsValid($isValid);
            
            if(true === $annotation->isCurrentMethod()){
                $hasFoundCurrentMethod = true;
                $this->currentAnnotationKey = $key;
            }
        }
        
        $this->validation = $wizardValidation;
    }
    
    public function getLastValidStep()
    {
        $lastStep = null;
        foreach($this->annotations as $key => $annotation){
            $handlerAnnotation = $annotation['handler'];
            if(!$handlerAnnotation->isValid()){
                return $lastStep;
            }
            $lastStep = $annotation;
        }
        throw new \RuntimeException("Not valid step found");
    }
    
    public function getSteps()
    {
        return $this->annotations;
    }
    
    /**
     * @return true|Response
     */
    public function getValidation()
    {
        return $this->validation;
    }
    
    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getNextStepUrl()
    {
        $key = $this->currentAnnotationKey+1;
        
        if(array_key_exists($key, $this->annotations)){
            return $this->getStepUrl($this->annotations[$key]);
        }
        
        throw new \InvalidArgumentException("No route found");
    }
    
    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getPrevStepUrl()
    {
        $key = $this->currentAnnotationKey-1;
        
        if(array_key_exists($key, $this->annotations)){
            return $this->getStepUrl($this->annotations[$key]);
        }
        
        throw new \InvalidArgumentException("No route found");
    }
    
    public function getStepUrl(array $annotation)
    {
        foreach($annotation['all'] as $annotation){
            if($annotation instanceof Route){
                return $this->router->generate($annotation->getName());
            }
        }
        
        throw new \InvalidArgumentException("No route found");
    }
}