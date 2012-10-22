<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation\WizardAction;

use Ibrows\Bundle\NewsletterBundle\Annotation\AbstractAnnotation;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Annotation
 */
class WizardActionAnnotation extends AbstractAnnotation
{
    public $name;
    public $number;
    public $validationMethod;
    public $isValid;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getNumber()
    {
        return $this->number;
    }
    
    public function getValidationMethod()
    {
        return $this->validationMethod;
    }
    
    public function isValid()
    {
        return $this->isValid;
    }
    
    public function setIsValid($flag = true)
    {
        $this->isValid = (bool)$flag;
    }
}