<?php

namespace Ibrows\Bundle\NewsletterBundle\Model\Job;

abstract class AbstractJob implements JobInterface
{
	protected $error;
	protected $status;
	
	protected $created;
	protected $scheduled;
	protected $completed;
	
	public function __construct()
	{
		$this->created = new \DateTime();
	}

	public function getError()
	{
		return $this->error;
	}
	
	public function setError($error)
	{
		$this->error = $error;
		return $this;
	}
	
    public function getStatus()
    {
        return $this->status;
    }
    
    public function getCreated()
    {
    		return $this->created;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getScheduled()
    {
        return $this->scheduled;
    }

    public function setScheduled(\DateTime $scheduled)
    {
        $this->scheduled = $scheduled;
        return $this;
    }

    public function getCompleted()
    {
        return $this->completed;
    }

    public function setCompleted(\DateTime $completed)
    {
        $this->completed = $completed;
        return $this;
    }

}
