<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

use Ibrows\Bundle\NewsletterBundle\Annotation\Wizard\Annotation as WizardAction;
use Ibrows\Bundle\NewsletterBundle\Annotation\Wizard\AnnotationHandler as WizardActionHandler;

use Doctrine\Common\Collections\Collection;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewsletterController extends AbstractController
{
	/**
	 * @Route("/", name="ibrows_newsletter_index")
	 */
	public function indexAction()
	{
        $this->setNewsletter(null);
        
        return $this->render($this->getTemplateManager()->getNewsletter('index'), array(
            
		));
	}
    
    /**
	 * @Route("/list", name="ibrows_newsletter_list")
	 */
	public function listAction()
	{
        $this->setNewsletter(null);
        
		return $this->render($this->getTemplateManager()->getNewsletter('list'), array(
            'newsletters' => $this->getMandant()->getNewsletters()
		));
	}
    
    /**
	 * @Route("/edit/redirection/{id}", name="ibrows_newsletter_edit_redirection")
	 */
	public function editredirectionAction($id)
	{
        $newsletter = $this->getNewsletterById($id);
        $this->setNewsletter($newsletter);
        
        return $this->redirect($this->generateUrl('ibrows_newsletter_meta'));
	}
	
	/**
	 * @Route("/create", name="ibrows_newsletter_create")
	 */
	public function createrediractionAction()
	{
		$this->setNewsletter(null);
        
        return $this->redirect($this->generateUrl('ibrows_newsletter_edit'));
	}
	
	/**
	 * @Route("/meta", name="ibrows_newsletter_meta")
	 * @WizardAction(name="meta", number=1, validationMethod="metaValidation")
	 */
	public function metaAction()
	{
        $newsletter = $this->getNewsletter();
        if($newsletter === null){
            $newsletter = $this->getNewsletterManager()->create();
        }
		
		$formtype = $this->getClassManager()->getForm('newsletter');
		$designClass = $this->getClassManager()->getModel('design');
		$form = $this->createForm(new $formtype($this->getMandantName(), $designClass), $newsletter);
		
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bind($request);
			
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
	
    public function metaValidation(WizardActionHandler $handler)
    {
        
    }
    
	/**
	 * @Route("/edit", name="ibrows_newsletter_edit")
     * @WizardAction(name="edit", number=2, validationMethod="editValidation")
	 */
	public function editAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }

        $request = $this->getRequest();
		if($request->getMethod() == 'POST'){
            $blockParameters = array();
            
            $blockPostArray = $request->request->get('block');
            if(!is_array($blockPostArray)){
               $blockPostArray = array(); 
            }
            
            $blockFileArray = $request->files->get('block');
            if(!is_array($blockFileArray)){
               $blockFileArray = array();
            }
            
            foreach($blockPostArray as $blockId => $content){
                $blockParameters[$blockId] = $content;
            }
            
            foreach($blockFileArray as $blockId => $file){
                $blockParameters[$blockId] = $file;
            }
            
            $newsletter = $this->getNewsletter();
            $this->updateBlocksRecursive($newsletter->getBlocks(), $blockParameters);
            $this->setNewsletter($newsletter);
            
            if($request->request->get('continue')){
                return $this->redirect($this->getWizardActionAnnotationHandler()->getNextStepUrl());
            }
		}

		return $this->render($this->getTemplateManager()->getNewsletter('edit'), array(
            'blockProviderManager' => $this->getBlockProviderManager(),
            'newsletter' => $this->getNewsletter(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function editValidation(WizardActionHandler $handler)
    {
        if(is_null($this->getNewsletter())){
            return $this->redirect($handler->getStepUrl($handler->getLastValidAnnotation()));
        }
    }
    
    /**
	 * @Route("/subscriber", name="ibrows_newsletter_subscriber")
     * @WizardAction(name="subscriber", number=3, validationMethod="subscriberValidation")
	 */
	public function subscriberAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }
        
        $newsletter = $this->getNewsletter();
        
        $formtype = $this->getClassManager()->getForm('subscriber');
		$subscriberClass = $this->getClassManager()->getModel('subscriber');
        $form = $this->createForm(new $formtype($this->getMandantName(), $subscriberClass), $newsletter);
        
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if($form->isValid()){
                $this->setNewsletter($newsletter);
                return $this->redirect($this->getWizardActionAnnotationHandler()->getNextStepUrl());
            }
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('subscriber'), array(
            'newsletter' => $this->getNewsletter(),
			'form' => $form->createView(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function subscriberValidation(WizardActionHandler $handler)
    {
        if(is_null($this->getNewsletter())){
            return $this->redirect($handler->getStepUrl($handler->getLastValidAnnotation()));
        }
    }
    
    /**
	 * @Route("/settings", name="ibrows_newsletter_settings")
     * @WizardAction(name="settings", number=4, validationMethod="settingsValidation")
	 */
	public function settingsAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }
        
        $formtype = $this->getClassManager()->getForm('sendsettings');
        $sendSettings = $this->getSendSettings();
        if ($sendSettings === null) {
	        $sendSettings = $this->getMandant()->getSendSettings();
	        $sendSettings->setStarttime(new \DateTime());
        }
        $form = $this->createForm(new $formtype(), $sendSettings);
        
        $request = $this->getRequest();
        if($request->getMethod() == 'POST'){
	        	$form->bind($request);
	        
	        	if($form->isValid()){
	        		$this->setSendSettings($sendSettings);
	        		return $this->redirect($this->getWizardActionAnnotationHandler()->getNextStepUrl());
	        	}
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('settings'), array(
            'newsletter' => $this->getNewsletter(),
            'form' => $form->createView(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
    
    public function settingsValidation(WizardActionHandler $handler)
    {
        $newsletter = $this->getNewsletter();
        
        if(is_null($newsletter)){
            return $this->redirect($handler->getStepUrl($handler->getLastValidAnnotation()));
        }
        
        if(count($newsletter->getSubscribers()) <= 0){
            return $this->redirect($this->generateUrl('ibrows_newsletter_subscriber'));
        }
    }
	
	/**
	 * @Route("/summary", name="ibrows_newsletter_summary")
     * @WizardAction(name="summary", number=5, validationMethod="summaryValidation")
	 */
	public function summaryAction()
	{
        if(($response = $this->getWizardActionValidation()) instanceof Response){
            return $response;
        }
        
        $newsletter = $this->getNewsletter();
        
        $subscribersArray = array();
        foreach($newsletter->getSubscribers() as $subscriber){
            $subscribersArray[$subscriber->getId()] = $subscriber;  
        }
        
        $formtypeClassName = $this->getClassManager()->getForm('testmail');
        $formtype = new $formtypeClassName(
            $subscribersArray,
            $this->getUser()->getEmail()
        );
        $testmailform = $this->createForm($formtype);
        
        $request = $this->getRequest();
        if($request->getMethod() == 'POST' && $request->request->get('testmail')){
            $testmailform->bind($request);

            if($testmailform->isValid()){
                $mandant = $this->getMandant();
                $subscriber = $testmailform->get('subscriber')->getData();
                $bridge = $this->getRendererBridge();
                
                $overview = $this->getRendererManager()->renderNewsletter(
                		$mandant->getRendererName(),
                		$bridge,
                		$newsletter,
                		$mandant,
                		$subscriber,
                		'testmail'
                );
                
                $mailjobClass = $this->getClassManager()->getModel('mailjob');
                $tomail = $testmailform->get('email')->getData();
                $mailjob = new $mailjobClass($newsletter, $this->getSendSettings());
                $mailjob->setToMail($tomail);
                $mailjob->setBody($overview);
                
                $this->send($mailjob);
            }
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('summary'), array(
            'newsletter' => $newsletter,
            'subscriber' => $newsletter->getSubscribers()->first(),
            'mandantHash' => $this->getMandant()->getHash(),
            'testmailform' => $testmailform->createView(),
            'wizard' => $this->getWizardActionAnnotationHandler(),
		));
	}
	
	protected function send(MailJob $job)
	{
		$this->get('ibrows_newsletter.mailer')->send($job);		
	}
    
    public function summaryValidation(WizardActionHandler $handler)
    {
        $newsletter = $this->getNewsletter();
        $sendSettings = $this->getSendSettings();
        
        if(is_null($newsletter) || is_null($sendSettings)){
            return $this->redirect($handler->getStepUrl($handler->getLastValidAnnotation()));
        }
        
        if(count($newsletter->getSubscribers()) <= 0){
            return $this->redirect($this->generateUrl('ibrows_newsletter_subscriber'));
        }
    }
    
    /**
     * @Route("/generate", name="ibrows_newsletter_generate")
     * @WizardAction(name="generate", number=6, validationMethod="summaryValidation")
     */
    public function generateAction()
    {
	    	if(($response = $this->getWizardActionValidation()) instanceof Response){
	    		return $response;
	    	}
	    	
    		$newsletter = $this->getNewsletter();
    		$sendSettings = $this->getSendSettings();
    		$mailjobClass = $this->getClassManager()->getModel('mailjob');
    		
		$mandant = $this->getMandant();
    		$rendererManager = $this->getRendererManager();
		$rendererName = $this->getMandant()->getRendererName();
		$bridge = $this->getRendererBridge();

		$objectManager = $this->getObjectManager();
		$subscribers = $newsletter->getSubscribers();
    		foreach ($subscribers as $subscriber) {
    			$body = $rendererManager->renderNewsletter(
    					$rendererName,
    					$bridge,
    					$newsletter,
    					$mandant,
    					$subscriber
    			);
    			
    			$mailjob = new $mailjobClass($newsletter, $sendSettings);
    			$mailjob->setBody($body);
    			$mailjob->setToMail($subscriber->getEmail());
    			
    			$objectManager->persist($mailjob);
    		}
    		
    		$objectManager->flush();
    		
    		return $this->render($this->getTemplateManager()->getNewsletter('generate'), array(
    			'newsletter' => $newsletter,
            'wizard' => $this->getWizardActionAnnotationHandler(),
    		));
    }
    
    public function generateValidation(WizardActionHandler $handler)
    {
    		return $this->summaryValidation($handler);
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
    
    protected function updateBlocksRecursive(Collection $blocks, array $blockParameters)
    {
        foreach($blocks as $block){
            $parameters = isset($blockParameters[$block->getId()]) ? 
                $blockParameters[$block->getId()] : null;

            $provider = $this->getBlockProviderManager()->get($block->getProviderName());
            $provider->updateBlock($block, $parameters);
            
            $this->updateBlocksRecursive($block->getBlocks(), $blockParameters);
        }
    }
}
