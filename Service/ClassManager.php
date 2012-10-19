<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class ClassManager
{
	private $model;
	private $form;
	
	public function __construct($model, $form)
	{
		$this->model = $model;
		$this->form = $form;
	}
	
	public function getModel($name)
	{
		if(!key_exists($name, $this->model)){
			throw new \InvalidArgumentException("The model class $name can not be found.");
		}
		
		$className = $this->model[$name];
        return new $className();
	}
	
	public function getForm($name)
	{
		if(!key_exists($name, $this->form)){
			throw new \InvalidArgumentException("The form class $name can not be found.");
		}
        
        $className = $this->form[$name];
        return new $className();
	}
}
