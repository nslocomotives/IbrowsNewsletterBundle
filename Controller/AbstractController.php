<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\TemplateManager;
use Ibrows\Bundle\NewsletterBundle\Service\ClassManager;

use Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @return MandantManager
     */
    public function getMandantManager()
    {
        return $this->get('ibrows_newsletter.mandant_manager');
    }
    
    /**
     * @return Mandant
     */
    public function getMandant()
    {
        $mandant = 'foo'; // get from auth token
        return $this->getMandantManager()->get($mandant);
    }
    
    /**
     * @return TemplateManager
     */
    public function getTemplateManager()
    {
        return $this->get('ibrows_newsletter.template_manager');
    }
    
    /**
     * @return ClassManager
     */
    public function getClassManager()
    {
        return $this->get('ibrows_newsletter.class_manager');
    }
}