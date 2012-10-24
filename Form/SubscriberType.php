<?php
namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriberType extends AbstractType
{
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
            
		;
	}

	/**
	 * 
	 */
	public function getName() {
		return 'ibrows_newsletterbundle_subscriber';
	}

}
