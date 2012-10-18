<?php
namespace Ibrows\Bundle\NewsletterBundle\Model;

interface MandantInterface
{
	public function getNewsletters();
	public function getNewsletter($id);
	public function createNewsletter();
}
