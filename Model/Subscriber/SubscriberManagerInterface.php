<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Subscriber;

interface SubscriberManagerInterface
{
	public function get($id);
	public function create();
}
