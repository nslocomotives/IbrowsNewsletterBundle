<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

interface NewsletterInterface
{
	public function getSubject();
	public function getSenderMail();
	public function getSenderName();
	public function getReturnMail();
}
