<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Log;

interface LogInterface
{
    public function getNewsletterId();
    public function getSubscriberId();
    public function getType();
    public function getMessage();
    public function getCreatedAt();
}