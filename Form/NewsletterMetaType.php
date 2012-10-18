<?php
namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class NewsletterMetaType extends AbstractType
{
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('subject')
			->add('sender_mail', 'email')
			->add('sender_name')
			->add('return_mail', 'email')
		;
	}

	/**
	 * 
	 */
	public function getName() {
		return 'ibrows_newsletterbundle_newsletter';
	}

}
