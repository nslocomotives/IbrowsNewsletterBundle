<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\TemplateManager;
use Ibrows\Bundle\NewsletterBundle\Service\ClassManager;
use Ibrows\Bundle\NewsletterBundle\Service\BlockManager;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantInterface;

use Ibrows\Bundle\NewsletterBundle\Annotation\Wizard\WizardActionAnnotationHandler;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class AbstractController extends Controller
{
    /**
     * @return MandantManager
     */
    protected function getMandantManager()
    {
        return $this->get('ibrows_newsletter.mandant_manager');
    }
    
    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->get('session');
    }
    
    /**
     * @return MandantInterface
     */
    protected function getMandant()
    {
        $mandant = MandantManager::DEFAULT_NAME; // get from auth token
        return $this->getMandantManager()->get($mandant);
    }
    
    /**
     * @return TemplateManager
     */
    protected function getTemplateManager()
    {
        return $this->get('ibrows_newsletter.template_manager');
    }
    
    /**
     * @return BlockManager
     */
    protected function getBlockManager()
    {
        return $this->get('ibrows_newsletter.block_manager');
    }
    
    /**
     * @return ClassManager
     */
    protected function getClassManager()
    {
        return $this->get('ibrows_newsletter.class_manager');
    }
    
    /**
     * @return WizardActionAnnotationHandler
     */
    protected function getWizardActionAnnotationHandler()
    {
        return $this->get('ibrows_newsletter.annotation.wizard.handler');
    }
    
    /**
     * @return true|Response
     */
    protected function getWizardActionValidation()
    {
        return $this->getWizardActionAnnotationHandler()->getValidation();
    }
    
    /**
     * @return NewsletterInterface
     */
    protected function createNewsletter()
    {
        return $this->getMandant()->createNewsletter();
    }
    
    /**
     * @param NewsletterInterface $newsletter
     * @return AbstractController
     */
    protected function setNewsletter(NewsletterInterface $newsletter = null)
    {
        $session = $this->getSession();
        
        if(is_null($newsletter)){
            $session->set('ibrows_newsletter.wizard.newsletterid', null);
            return $this;
        }
        
        $this->getMandant()->persist($newsletter);
        $session->set('ibrows_newsletter.wizard.newsletterid', $newsletter->getId());
        
        return $this;
    }
    
    /**
     * @return Newsletter
     * @throws NotFoundException
     */
    protected function getNewsletter()
    {
        $newsletterId = $this->getSession()->get('ibrows_newsletter.wizard.newsletterid', null);
        if(is_null($newsletterId)){
            return null;
        }
        
        $newsletter = $this->getMandant()->getNewsletter($newsletterId);
        if(!$newsletter){
            throw $this->createNotFoundException("Newsletter with id $id not found");
        }
        
        return $newsletter;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Bundle\FrameworkBundle\Controller.Controller::render()
     */
	public function render($view, array $parameters = array(), Response $response = null)
    {
    		$basetemplate = $this->getTemplateManager()->getBaseTemplate();
    		$parameters = array_merge($parameters, array('basetemplate' => $basetemplate));
    		
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}