<?php

namespace Ibrows\Bundle\NewsletterBundle\Entity;

use Ibrows\Bundle\NewsletterBundle\Model\Log\Log as BaseLog;

use Doctrine\ORM\Mapping as ORM;

class Log extends BaseLog
{
    /**
     * @ORM\Column(type="integer", name="newsletter_id")
     */
    protected $newsletterId;

    /**
     * @ORM\Column(type="integer", name="subscriber_id")
     */
    protected $subscriberId;

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="text")
     */
    protected $message;
}