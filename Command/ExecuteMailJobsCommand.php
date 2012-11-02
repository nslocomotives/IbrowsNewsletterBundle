<?php

namespace Ibrows\Bundle\NewsletterBundle\Command;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;

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
			->addOption(
					'mandant',
					null,
					InputOption::VALUE_REQUIRED,
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
		$mandantName = $input->getOption('mandant');
		$jobClass = $this->getContainer()->getParameter('ibrows_newsletter.classes.model.mailjob');
		
		$now = new \DateTime();
		$timestamp_now = $now->getTimestamp();
		
		$mailer = $this->getContainer()->get('ibrows_newsletter.mailer');
		$mm = $this->getContainer()->get('ibrows_newsletter.mandant_manager');
		$manager = $mm->getObjectManager($mandantName);
		
		// set status working
		$jobs = $manager->getRepository($jobClass)->findBy(array('status' => MailJob::STATUS_READY));
		foreach ($jobs as $job) {
			$job->setStatus(MailJob::STATUS_WORKING);
			$manager->persist($job);
		}
		$manager->flush();
		$manager->clear();
		
		// send jobs
		foreach ($jobs as $job) {
			$timestamp_job = $job->getScheduled()->getTimestamp();
			
			if($output->getVerbosity() > 1) {
    				$output->writeln('Processing job # '.$job->getId());
			}
			
			if ($timestamp_job > $timestamp_now) {
				if($output->getVerbosity() > 1) {
					$output->writeln('    <info>the time has not come yet.</info>');
				}
				$job->setStatus(MailJob::STATUS_READY);
				$manager->merge($job);
				continue;
			}

			try {
				if($output->getVerbosity() > 1) {
					$output->writeln('    <info>your time has come.</info>');
				}
				$mailer->send($job);
				$job->setStatus(MailJob::STATUS_COMPLETED);
			} catch (\Swift_SwiftException $e) {
				if($output->getVerbosity() > 1) {
					$output->writeln('    <info>something went wrong.</info>');
					$output->writeln($e->getMessage());
				}
				$job->setStatus(MailJob::STATUS_ERROR);
				$job->setError($e->getTraceAsString());
			}
			
			$manager->merge($job);
		}
		
		$manager->flush();
	}

}
