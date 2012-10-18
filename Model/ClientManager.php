<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

abstract class ClientManager implements ClientManagerInterface
{
	const DEFAULT_NAME = 'default';
	
	protected function canonicalizeName($name = null)
	{
		if ($name === null){
			return self::DEFAULT_NAME;
		}

		return $name;
	}
}