<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface NewsletterInterface
{
	public function getSubject();
	public function getSenderMail();
	public function getSenderName();
	public function getReturnMail();
}
