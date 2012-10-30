<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Log;

interface LogInterface
{
    public function getId();
    public function getNewsletterId();
    public function getSubscriberId();
    public function getType();
    public function getMessage();
    public function getCreatedAt();

    /**
     * @param $newsletterId
     * @return LogInterface
     */
    public function setNewsletterId($newsletterId);

    /**
     * @param $subscriberId
     * @return LogInterface
     */
    public function setSubscriberId($subscriberId);

    /**
     * @param $message
     * @return LogInterface
     */
    public function setMessage($message);
}