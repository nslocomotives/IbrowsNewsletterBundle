<?php

namespace Ibrows\Bundle\NewsletterBundle\Command;

use Doctrine\DBAL\LockMode;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExecuteMailJobsCommand extends ContainerAwareCommand
{
	/**
	 * 
	 */
	protected function configure() {
		$this
			->setName('ibrows:newsletter:job:mail:send')
			->setDescription('Executes (sends) all ready mailjobs.')
			->addArgument(
					'mandant',
					InputArgument::REQUIRED,
					'The mandant to use'
			)
		;
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @throws \LogicException
	 */
	protected function execute(InputInterface $input, OutputInterface $output) {
		$mandantName = $input->getArgument('mandant');
		$jobClass = $this->getContainer()->getParameter('ibrows_newsletter.classes.model.mailjob');
		$now = new \DateTime();
		
		$ms = $this->getContainer()->get('ibrows_newsletter.mailer');
		$mm = $this->getContainer()->get('ibrows_newsletter.mandant_manager');
		$manager = $mm->getObjectManager($mandantName);
		
		$manager->lock($jobClass, LockMode::PESSIMISTIC_WRITE);
		$jobs = $manager->getRepository($jobClass)->findBy(array('status' => MailJob::STATUS_READY));
		foreach ($jobs as $job) {
			$job->setStatus(MailJob::STATUS_WORKING);
			$manager->persist($job);
		}
		$manager->flush();
		$manager->unlock($jobClass);
		$manager->clear();
		
		foreach ($jobs as $job) {
			if ($job->getScheduled() < $now) {
				break;
			}
			
			try {
				$ms->send($job);
				$job->setStatus(MailJob::STATUS_COMPLETED);
			} catch (\Swift_SwiftException $e) {
				$job->setStatus(MailJob::STATUS_ERROR);
				$job->setError($e->getTraceAsString());
			}
			
			$manager->persist($job);
		}
		
		$manager->flush();
	}

}
