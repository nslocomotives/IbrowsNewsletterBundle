<?php

namespace Ibrows\Bundle\NewsletterBundle\Form;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class NewsletterType extends AbstractType
{
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('subject')
            ->add('name')
			->add('senderMail', 'email')
			->add('senderName')
			->add('returnMail', 'email')
			->add('design')
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
		return 'ibrows_newsletterbundle_newsletter';
	}

}
