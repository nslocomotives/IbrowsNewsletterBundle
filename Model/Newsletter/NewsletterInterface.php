<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface NewsletterInterface
{
    public function getName();
    public function getCreatedAt();
	public function getMandant();
	public function getSubject();
	public function getSenderMail();
	public function getSenderName();
	public function getReturnMail();
    public function getBlocks();
    public function getId();
    public function getSubscribers();
    public function getDesign();
}
