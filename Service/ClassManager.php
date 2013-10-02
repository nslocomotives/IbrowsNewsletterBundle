<?php

namespace Ibrows\Bundle\NewsletterBundle\Service;

class ClassManager
{
    /**
     * @var array
     */
    protected $models = array();

    /**
     * @var array
     */
    protected $forms = array();

    /**
     * @param array $models
     * @param array $forms
     */
    public function __construct(array $models, array $forms)
	{
		$this->models = $models;
		$this->forms = $forms;
	}

    /**
     * @param string $name
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getModel($name)
	{
		if(!array_key_exists($name, $this->models)){
			throw new \InvalidArgumentException("The model class '$name' can not be found.");
		}
		
		return $this->models[$name];
	}

    /**
     * @param string $name
     * @return string
     * @throws \InvalidArgumentException
     */
    public function getForm($name)
	{
		if(!array_key_exists($name, $this->forms)){
			throw new \InvalidArgumentException("The form class '$name' can not be found.");
		}
        
        return $this->forms[$name];
	}
}
