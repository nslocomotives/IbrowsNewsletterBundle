<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Form\NewsletterFormType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsletterController extends AbstractController
{
	/**
	 * @Route("/", name="ibrows_newsletter_index")
	 */
	public function indexAction()
	{
		return $this->render($this->getTemplateManager()->getNewsletter('index'), array(
            'newsletters' => $this->getMandant()->getNewsletters()
		));
	}
	
	/**
	 * @Route("/create", name="ibrows_newsletter_create")
	 */
	public function createAction()
	{
        $mandant = $this->getMandant();
		$newsletter = $mandant->createNewsletter();
		
		$formtype = $this->getClassManager()->getForm('newsletter_meta');
		$form = $this->createForm($formtype, $newsletter);
		
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$form->bindRequest($request);
			
			if($form->isValid()){
				$mandant->persist($newsletter);
				
				return $this->redirect($this->generateUrl('ibrows_newsletter_edit', array(
                    'id' => $newsletter->getId(),
				)));
			}
		}
	
		return $this->render($this->getTemplateManager()->getNewsletter('create'), array(
            'newsletter' => $newsletter,
            'form' => $form->createView(),
		));
	}
	
	/**
	 * @Route("/edit/{id}", name="ibrows_newsletter_edit")
	 */
	public function editAction($id)
	{
        $newsletter = $this->getMandant()->getNewsletter($id);
        if(!$newsletter){
            throw $this->createNotFoundException("Newsletter with id $id not found");
        }
        
        $formtype = $this->getClassManager()->getForm('newsletter_content');
		$form = $this->createForm($formtype, $newsletter);
        
		return $this->render($this->getTemplateManager()->getNewsletter('edit'), array(
            'newsletter' => $newsletter,
            'form' => $form->createView()
		));
	}
	
	/**
	 * @Route("/send/{id}", name="ibrows_newsletter_send")
	 */
	public function sendAction($id)
	{
        $newsletter = $this->getMandant()->getNewsletter($id);
        if(!$newsletter){
            throw $this->createNotFoundException("Newsletter with id $id not found");
        }
        
		return $this->render($this->getTemplateManager()->getNewsletter('send'), array(
            'newsletter' => $newsletter
		));
	}
	
	/**
	 * @Route("/summary/{id}", name="ibrows_newsletter_summary")
	 */
	public function summaryAction($id)
	{
		return $this->render($this->getTemplateManager()->getNewsletter('summary'), array(
            'newsletter' => $this->getMandant()->getNewsletter($id)
		));
	}
}
