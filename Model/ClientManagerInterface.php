<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

interface ClientManagerInterface
{
	public function create($name);
	public function get($name);
}
