<?php
namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NewsletterController extends Controller
{
	/**
	 * @Route("/", name="ibrows_newsletter_index")
	 * @Template()
	 */
	public function indexAction()
	{
		
	}
	
	/**
	 * @Route("/create", name="ibrows_newsletter_create")
	 * @Template()
	 */
	public function createAction()
	{
		
	}
	
	/**
	 * @Route("/{id}/edit", name="ibrows_newsletter_edit")
	 * @Template()
	 */
	public function editAction()
	{
		
	}
	
	/**
	 * @Route("/{id}/send", name="ibrows_newsletter_send")
	 * @Template()
	 */
	public function sendAction()
	{
		
	}
	
	/**
	 * @Route("/{id}/summary", name="ibrows_newsletter_summary")
	 * @Template()
	 */
	public function summaryAction()
	{
		
	}
}
