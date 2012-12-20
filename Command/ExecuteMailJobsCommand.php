<?php

namespace Ibrows\Bundle\NewsletterBundle\Command;

use Ibrows\Bundle\NewsletterBundle\Model\Job\MailJob;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputOption;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

class ExecuteMailJobsCommand extends ContainerAwareCommand
{
	protected $jobClass;
	protected $mm;
	protected $timestamp_now;
	
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
                InputOption::VALUE_OPTIONAL,
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
		$this->jobClass = $this->getContainer()->getParameter('ibrows_newsletter.classes.model.mailjob');
		$this->mm = $this->getContainer()->get('ibrows_newsletter.mandant_manager');
		$now = new \DateTime();
		$this->timestamp_now = $now->getTimestamp();

		$mandantName = $input->getOption('mandant');
		if ($mandantName === null) {
			$mandantNames = $this->mm->getMandants();
			foreach ($mandantNames as $name => $description) {
				$this->sendMails($input, $output, $name);
			}
		} else {
			$this->sendMails($input, $output, $mandantName);
		}
	}

	protected function sendMails(InputInterface $input, OutputInterface $output, $mandantName) {
		$manager = $this->mm->getObjectManager($mandantName);
		
		// set status working
		$jobs = $manager->getRepository($this->jobClass)->findBy(array('status' => MailJob::STATUS_READY));
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
				$output->writeln('Processing job # '.$job->getId()." for mandant $mandantName");
			}
				
			if ($timestamp_job > $this->timestamp_now) {
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
				$this->getContainer()->get('ibrows_newsletter.mailer')->send($job);
				$job->setStatus(MailJob::STATUS_COMPLETED);
			} catch (\Swift_SwiftException $e) {
				if($output->getVerbosity() > 1) {
					$output->writeln('    <info>something went wrong.</info>');
					$output->writeln($e->getMessage());
				}
				$job->setStatus(MailJob::STATUS_ERROR);
				$job->setError($e->getMessage().'||'.$e->getTraceAsString());
			}
				
			$job->setCompleted(new \DateTime());
			$manager->merge($job);
		}
		
		$manager->flush();
	}
}
