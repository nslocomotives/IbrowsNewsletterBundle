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
}