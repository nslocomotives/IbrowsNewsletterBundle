<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation;

abstract class AbstractAnnotation implements AnnotationInterface
{
    protected $isCurrentMethod = false;

    public function setIsCurrentMethod($flag = true){
        $this->isCurrentMethod = (bool)$flag;
    }
    
    public function isCurrentMethod(){
        return $this->isCurrentMethod;
    }
}