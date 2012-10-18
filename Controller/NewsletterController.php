<?php
namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Form\NewsletterFormType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsletterController extends Controller
{
	/**
	 * @Route("/{client}/", defaults={"client" = "default"}, name="ibrows_newsletter_index")
	 */
	public function indexAction($client)
	{
		$templates = $this->get('ibrows_newsletter.template_manager');
		$client = $this->get('ibrows_newsletter.client_manager')->get($client);
		$newsletters = $client->getNewsletters();
		
		return $this->render($templates->getNewsletter('index'), array(
				'newsletters' => $newsletters
		));
	}
	
	/**
	 * @Route("/{client}/create", defaults={"client" = "default"}, name="ibrows_newsletter_create")
	 */
	public function createAction($client)
	{
		$templates = $this->get('ibrows_newsletter.template_manager');
		$classes = $this->get('ibrows_newsletter.class_manager');

		$client = $this->get('ibrows_newsletter.client_manager')->get($client);
		$newsletter = $client->createNewsletter();
		
		$formtype = $classes->getForm('newsletter_meta');
		$form = $this->createForm(new $formtype(), $newsletter);
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			
			if ($form->isValid()) {
				$client->persist($newsletter);
				
				return $this->redirect($this->generateUrl('ibrows_newsletter_edit', array(
						'client' => $client->getName(),
						'id' => $newsletter->getId(),
				)));
			}
		}
	
		return $this->render($templates->getNewsletter('create'), array(
				'newsletter' => $newsletter,
				'client' => $client->getName(),
				'form' => $form->createView(),
		));
	}
	
	/**
	 * @Route("/{client}/edit/{id}", defaults={"client" = "default"}, name="ibrows_newsletter_edit")
	 */
	public function editAction($client, $id)
	{
		$templates = $this->get('ibrows_newsletter.template_manager');
		$classes = $this->get('ibrows_newsletter.class_manager');

		$object = $this->get('ibrows_newsletter.client_manager')->get($client);
		$newsletter = $object->createNewsletter();
		
		$formtype = $classes->getForm('newsletter_content');
		$form = $this->createForm(new $formtype(), $newsletter);
	
		return $this->render($templates->getNewsletter('edit'), array(
				'newsletter' => $newsletter,
				'client' => $client,
				'form' => $form->createView(),
		));
	}
	
	/**
	 * @Route("/{client}/send/{id}", defaults={"client" = "default"}, name="ibrows_newsletter_send")
	 */
	public function sendAction($client, $id)
	{
		$templates = $this->get('ibrows_newsletter.template_manager');
		$client = $this->get('ibrows_newsletter.client_manager')->get($client);
		$newsletter = $client->getNewsletter($id);
		
		return $this->render($templates->getNewsletter('send'), array(
				'newsletter' => $newsletter
		));
	}
	
	/**
	 * @Route("/{client}/summary/{id}", defaults={"client" = "default"}, name="ibrows_newsletter_summary")
	 */
	public function summaryAction($client, $id)
	{
		$templates = $this->get('ibrows_newsletter.template_manager');
		$client = $this->get('ibrows_newsletter.client_manager')->get($client);
		$newsletter = $client->getNewsletter($id);
		
		return $this->render($templates->getNewsletter('summary'), array(
				'newsletter' => $newsletter
		));
	}
}
