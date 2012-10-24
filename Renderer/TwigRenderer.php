<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

use Symfony\Bridge\Twig\TwigEngine;

class TwigRenderer implements RendererInterface
{
	protected $engine;
	
	public function __construct()
	{
		$this->engine = new \Twig_Environment();
		$stringloader = new \Twig_Loader_String();
		$this->engine->setLoader($stringloader);
	}

	public function render(RenderableInterface $element, array $parameters = array())
	{
		try {
			$rendered = $this->engine->render($element->getContent(), $parameters);
			
		} catch (\Exception $e) {
			$rendered = $e->getMessage();
		}
		
		return $rendered;
	}

}
