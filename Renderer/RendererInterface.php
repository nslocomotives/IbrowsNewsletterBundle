<?php

namespace Ibrows\Bundle\NewsletterBundle\Renderer;

interface RendererInterface
{
    public function render(RendereableInterface $element);
}