<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface SendSettingsInerface
{
    public function getTransport();
    public function setTransport($transport);

    public function getUsername();
    public function setUsername($username);

    public function getPassword();
    public function setPassword($password);

    public function getHost();
    public function setHost($host);

    public function getPort();
    public function setPort($port);

    public function getInterval();
    public function setInterval($interval);
    
    public function getStarttime();
    public function setStarttime($starttime);
}
