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
            ->add('username')
            ->add('password', 'password')
            ->add('host')
            ->add('port')
            ->add('encryption', 'choice', array(
            			'choices' => array('tls' => 'tls', 'ssl' => 'ssl'),
            			'required' => false,
            			'empty_data' => null,
            		))
            ->add('authMode', 'choice', array(
            			'choices' => array('plain' => 'plain', 'login' => 'login', 'cram-md5' => 'cram-md5'),
            			'required' => false,
            			'empty_data' => null,
            		))
            ->add('interval')
            ->add('starttime', 'datetime')
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
