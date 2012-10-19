<?php
namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

class NewsletterContentType extends AbstractType
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
		return 'ibrows_newsletterbundle_newsletter';
	}

}
