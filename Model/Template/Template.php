<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Template;

class Template
{
	protected $name;
	
	protected $content;

	public function getName()
	{
	    return $this->name;
	}

	public function setName($name)
	{
	    $this->name = $name;
	    return $this;
	}

	public function getContent()
	{
	    return $this->content;
	}

	public function setContent($content)
	{
	    $this->content = $content;
	    return $this;
	}
}
