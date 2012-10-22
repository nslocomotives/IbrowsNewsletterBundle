<?php
namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/design")
 */
class DesignController extends AbstractController
{
	/**
	 * @Route("/", name="ibrows_newsletter_design_index")
	 */
	public function indexAction()
	{
		return $this->render($this->getTemplateManager()->getDesign('index'));
	}
	
	/**
	 * @Route("/create", name="ibrows_newsletter_design_create")
	 */
	public function createAction()
	{
		return $this->render($this->getTemplateManager()->getDesign('create'));
	}
	
	/**
	 * @Route("/edit/{id}", name="ibrows_newsletter_design_edit")
	 */
	public function editAction($id)
	{
		return $this->render($this->getTemplateManager()->getDesign('edit'));
	}
	
	/**
	 * @Route("/show/{id}", name="ibrows_newsletter_design_show")
	 */
	public function showAction($id)
	{
		return $this->render($this->getTemplateManager()->getDesign('show'));
	}
}
