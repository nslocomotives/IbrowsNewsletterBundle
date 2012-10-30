<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

abstract class AbstractHashMandantController extends AbstractController
{
    protected $mandantName = null;

    protected function getMandantName()
    {
        if(!$this->mandantName){
            throw $this->createNotFoundException("No mandant-name set!");
        }
        return $this->mandantName;
    }

    protected function setMandantNameByHash($hash)
    {
        $this->mandantName = $this->getMandantNameByHash($hash);
    }
}
