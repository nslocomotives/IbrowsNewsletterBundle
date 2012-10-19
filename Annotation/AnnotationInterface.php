<?php

namespace Ibrows\Bundle\NewsletterBundle\Annotation;

interface AnnotationInterface
{
    public function setIsCurrentMethod($flag = true);
    public function isCurrentMethod();
}