<?php
namespace Ibrows\Bundle\NewsletterBundle\Service;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

class TemplateManager
{
	private $client;
	private $newsletter;
	
	public function __construct(array $client, array $newsletter)
	{
		$this->client = $client;
		$this->newsletter = $newsletter;
	}
	
	public function getNewsletter($name)
	{
		if (!key_exists($name, $this->newsletter)) {
			throw new UnexpectedValueException("The template for view $name can not be configured.", $code, $previous);
		}
		
		return $this->newsletter[$name];
	}
	
	public function getClient($name)
	{
		if (!key_exists($name, $this->client)) {
			throw new UnexpectedValueException("The template for view $name can not be configured.", $code, $previous);
		}
	
		return $this->client[$name];
	}
}
