<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

use Symfony\Bridge\Twig\TwigEngine;

class TwigRenderer implements RendererInterface
{
	protected $engine;
	protected $origloader;
	protected $stringloader;
	
	public function __construct(\Twig_Environment $engine)
	{
		$this->engine = $engine;
		$this->origloader = $engine->getLoader();
		$this->stringloader = new \Twig_Loader_String();
	}

	public function render(RenderableInterface $element, array $parameters = array())
	{
		$this->engine->setLoader($this->stringloader);
		
		$rendered = $this->engine->render($element->getContent(), $parameters);
		
		$this->engine->setLoader($this->origloader);
		return $rendered;
	}

}
