<?php
namespace Ibrows\Bundle\NewsletterBundle\Form;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Bridge\Doctrine\Form\ChoiceList\EntityChoiceList;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class SubscriberType extends AbstractType
{
	protected $subscriberChoiceList;
	
	public function __construct(ObjectManager $manager, $subscriberClass)
	{
		$this->subscriberChoiceList = new EntityChoiceList($manager, $subscriberClass);
	}
	
	/**
	 * @param FormBuilderInterface $builder
	 * @param array $options
	 */
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
            ->add('subscribers', 'choice', array(
            		'choice_list' => $this->subscriberChoiceList,
            ))
		;
	}

	/**
	 * 
	 */
	public function getName() {
		return 'ibrows_newsletterbundle_subscriber';
	}

}
