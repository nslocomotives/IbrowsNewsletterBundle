<?php

namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SendSettingsType extends AbstractType
{
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
            ->add('transport')
            ->add('username')
            ->add('password')
            ->add('host')
            ->add('port')
            ->add('interval')
		;
	}
	
	/**
	 * @param OptionsResolverInterface $resolver
	 */
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		parent::setDefaultOptions($resolver);
		$resolver->setDefaults(array(
				'validation_groups' => array('newsletter'),
		));
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return 'ibrows_newsletterbundle_send_settings';
	}
}
