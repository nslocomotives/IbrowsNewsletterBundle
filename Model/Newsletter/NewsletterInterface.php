<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface NewsletterInterface
{
	public function getMandant();
	public function getSubject();
	public function getSenderMail();
	public function getSenderName();
	public function getReturnMail();
    public function getBlocks();
    public function getId();
    public function getSubscribers();
}
