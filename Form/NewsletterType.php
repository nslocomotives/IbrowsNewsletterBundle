<?php

namespace Ibrows\Bundle\NewsletterBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class NewsletterType extends AbstractType
{
	protected $designChoicesList;
	
	public function __construct(ObjectManager $manager, $designClass)
	{
		$this->designChoicesList = new EntityChoiceList($manager, $designClass);
	}
	
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
			->add('design', 'choice', array(
					'choice_list' => $this->designChoicesList,
			))
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
