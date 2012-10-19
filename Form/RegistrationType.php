<?php
namespace Acme\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationType extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->add('mandant');
	}
	
	public function getName()
	{
		return 'ibrows_newsletter_user_registration';
	}
}
