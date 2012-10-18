<?php
namespace Ibrows\Bundle\NewsletterBundle\Model;

interface ClientInterface
{
	public function getNewsletters();
	public function getNewsletter($id);
	public function createNewsletter();
}
