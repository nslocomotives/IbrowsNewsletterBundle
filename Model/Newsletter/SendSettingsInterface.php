<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Newsletter;

interface SendSettingsInterface
{
    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     * @return SendSettingsInterface
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     * @return SendSettingsInterface
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getHost();

    /**
     * @param string $host
     * @return SendSettingsInterface
     */
    public function setHost($host);

    /**
     * @return int
     */
    public function getPort();

    /**
     * @param int $port
     * @return SendSettingsInterface
     */
    public function setPort($port);

    /**
     * @return int
     */
    public function getInterval();

    /**
     * @param int $interval
     * @return SendSettingsInterface
     */
    public function setInterval($interval);

    /**
     * @return \DateTime
     */
    public function getStarttime();

    /**
     * @param \DateTime $starttime
     * @return SendSettingsInterface
     */
    public function setStarttime(\DateTime $starttime = null);

    /**
     * @return string
     */
    public function getEncryption();

    /**
     * @param string $encryption
     * @return SendSettingsInterface
     */
    public function setEncryption($encryption);

    /**
     * @return string
     */
    public function getAuthMode();

    /**
     * @param string $authMode
     * @return SendSettingsInterface
     */
    public function setAuthMode($authMode);
}
