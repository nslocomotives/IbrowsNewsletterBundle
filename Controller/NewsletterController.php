<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Form\NewsletterFormType;
use Ibrows\Bundle\NewsletterBundle\Annotation\WizardAction\WizardActionAnnotation;
use Ibrows\Bundle\NewsletterBundle\Annotation\WizardAction\WizardActionAnnotationHandler;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class NewsletterController extends AbstractController
{
	/**
	 * @Route("/", name="ibrows_newsletter_index")
	 */
	public function indexAction()
	{
        $this->setNewsletter(null);
        
		return $this->render($this->getTemplateManager()->getNewsletter('index'), array(
            'newsletters' => $this->getMandant()->getNewsletters()
		));
	}
	
	/**
	 * @Route("/create", name="ibrows_newsletter_create")
     * @WizardActionAnnotation(name="create", number=1, validationMethod="createValidation")
	 */
	public function createAction()
	{
        $this->setNewsletter(null);
        
		$newsletter = $this->createNewsletter();
		
		$formtype = $this->getClassManager()->getForm('newsletter_meta');
		$form = $this->createForm(new $formtype(), $newsletter);
		
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bindRequest($request);
			
			if($form->isValid()){
                $this->setNewsletter($newsletter);
				return $this->redirect($this->getWizardActionAnnotationHandler()->getNextStepUrl());
			}
		}
	
		return $this->render($this->getTemplateManager()->getNewsletter('create'), array(
            'newsletter' => $newsletter,
            'form' => $form->createView(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
	
    public function createValidation(WizardActionAnnotationHandler $handler)
    {
        
    }
    
	/**
	 * @Route("/edit", name="ibrows_newsletter_edit")
     * @WizardActionAnnotation(name="edit", number=2, validationMethod="editValidation")
	 */
	public function editAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }

        $request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			return $this->redirect($this->getWizardActionAnnotationHandler()->getNextStepUrl());
		}
        
		return $this->render($this->getTemplateManager()->getNewsletter('edit'), array(
            'newsletter' => $this->getNewsletter(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function editValidation(WizardActionAnnotationHandler $handler)
    {
        if(is_null($this->getNewsletter())){
            return $this->redirect($handler->getStepUrl($handler->getLastValidStep()));
        }
    }
    
    /**
	 * @Route("/recipient", name="ibrows_newsletter_recipient")
     * @WizardActionAnnotation(name="recipient", number=3, validationMethod="recipientValidation")
	 */
	public function recipientAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('recipient'), array(
            'newsletter' => $this->getNewsletter(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function recipientValidation(WizardActionAnnotationHandler $handler)
    {
        if(is_null($this->getNewsletter())){
            return $this->redirect($handler->getStepUrl($handler->getLastValidStep()));
        }
    }
	
	/**
	 * @Route("/summary", name="ibrows_newsletter_summary")
     * @WizardActionAnnotation(name="summary", number=4, validationMethod="summaryValidation")
	 */
	public function summaryAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('summary'), array(
            'newsletter' => $this->getNewsletter(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function summaryValidation(WizardActionAnnotationHandler $handler)
    {
        if(is_null($this->getNewsletter())){
            return $this->redirect($handler->getStepUrl($handler->getLastValidStep()));
        }
    }
    
    /**
	 * @Route("/send", name="ibrows_newsletter_send")
	 */
	public function sendAction()
	{
        $newsletter = $this->getNewsletter();
        if(is_null($newsletter)){
            return $this->redirect($this->generateUrl('ibrows_newsletter_index', array(), true));
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('send'), array(
            'newsletter' => $newsletter
		));
	}
}
