<?php
namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
			->add('senderMail', 'email')
			->add('senderName')
			->add('returnMail', 'email')
		;
	}
	
	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
				'validation_groups' => array('newsletter'),
		));
	}

	/**
	 * 
	 */
	public function getName() {
		return 'ibrows_newsletterbundle_newsletter';
	}

}
