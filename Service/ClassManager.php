<?php
namespace Ibrows\Bundle\NewsletterBundle\Service;

use Symfony\Component\Serializer\Exception\UnexpectedValueException;

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
		if (!key_exists($name, $this->model)) {
			throw new UnexpectedValueException("The model class $name can not be found.");
		}
		
		return $this->model[$name];
	}
	
	public function getForm($name)
	{
		if (!key_exists($name, $this->form)) {
			throw new UnexpectedValueException("The form class $name can not be found.");
		}
	
		return $this->form[$name];
	}
}
