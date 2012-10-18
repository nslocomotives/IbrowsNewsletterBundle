<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Block;

interface BlockInterface
{
    public function getName();
    public function getContent();
}