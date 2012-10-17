<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

interface ClientManagerInterface
{
	public function createClient($name);
	public function getClient($name);
}
