<?php

namespace Ibrows\Bundle\NewsletterBundle\Model;

abstract class ClientManager implements ClientManagerInterface
{
	protected function canonicalizeName($name = null)
	{
		if ($name === null){
			return null;
		}

		return 'ibrows_newsletter_client_'.$name;
	}
}