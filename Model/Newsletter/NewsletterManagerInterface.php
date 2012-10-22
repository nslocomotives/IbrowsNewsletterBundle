<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface NewsletterManagerInterface
{
	public function get($id);
	public function create();
}
