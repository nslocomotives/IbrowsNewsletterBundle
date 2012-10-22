<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Mandant;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;

interface MandantManagerInterface
{
	const DEFAULT_NAME = 'default';
	
	/**
	 * @param string $name
	 */
	public function get($name);
	/**
	 * @param string $name
	 * @return \Symfony\Component\Security\Core\User\UserProviderInterface
	 */
	public function getUserProvider($name);
	/**
	 * @param string $name
	 * @return \Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterManagerInterface
	 */
	public function getNewsletterManager($name);
	/**
	 * @param string $name
	 * @param NewsletterInterface $newsletter
	 * @return NewsletterInterface|null
	 */
	public function persistNewsletter($name, NewsletterInterface $newsletter);
}
