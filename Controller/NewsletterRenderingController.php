<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Ibrows\Bundle\NewsletterBundle\Entity\Newsletter;
use Ibrows\Bundle\NewsletterBundle\Entity\Subscriber;
use Ibrows\Bundle\NewsletterBundle\Block\BlockComposition;

/**
 * @Route("/render")
 */
class NewsletterRenderingController extends AbstractHashMandantController
{
	protected function getBridgeService()
	{
        $bridgeServiceId = $this->container->getParameter('ibrows_newsletter.rendererbridgeserviceid');
        return $this->get($bridgeServiceId);
	}
	
	protected function getRendererService()
	{
		return $this->getRendererManager()->get($this->getMandant()->getRendererName());
	}
	
    /**
     * @Route("/show/{mandantHash}/{newsletterHash}/{subscriberHash}", name="ibrows_newsletter_render_overview")
     */
    public function showAction($mandantHash, $newsletterHash, $subscriberHash)
    {
        $this->setMandantNameByHash($mandantHash);

        $newsletter = $this->getNewsletterByHash($newsletterHash);
        $subscriber = $this->getSubscriberByHash($newsletter, $subscriberHash);

        $renderer = $this->getRendererService();

        $blockVariables = array(
            'context' => $this->getRequest()->query->get('context'),
            'mandant' => $this->getMandant(),
            'newsletter' => $newsletter,
            'subscriber' => $subscriber,
            'bridge' => $this->getRendererBridge(),
        );

        $blockContent = $renderer->render(
            new BlockComposition($this->getBlockProviderManager(), $newsletter->getBlocks()),
            $blockVariables
        );

        $overview = $renderer->render($newsletter->getDesign(), array_merge($blockVariables, array(
            'content' => $blockContent
        )));

        return $this->render($this->getTemplateManager()->getNewsletter('overview'), array(
            'overview' => $overview
        ));
    }
    
    /**
     * @Route("/show/design/{id}", name="ibrows_newsletter_render_design")
     */
    public function showDesignPreviewAction($id)
    {
    		$dm = $this->getDesignManager();
    		$design = $dm->get($id);
    		
    		$newsletter = $this->createTestNewsletter($design);
    		$subscriber = $this->createTestSubscriber();
    		
    		$renderer = $this->getRendererService();
    		$bridge = $this->getRendererBridge();
    		
    		$blockVariables = array(
    				'context' => 'preview',
    				'mandant' => $this->getMandant(),
    				'newsletter' => $newsletter,
    				'subscriber' => $subscriber,
    				'bridge' => $bridge,
    		);
    		
    		$overview = $renderer->render($newsletter->getDesign(), array_merge($blockVariables, array(
    				'content' => '{{ content }}'
    		)));
    		
    		return $this->render($this->getTemplateManager()->getNewsletter('overview'), array(
    				'overview' => $overview
    		));
    }
    
    protected function createTestNewsletter($design)
    {
    		$newsletter = new Newsletter();
    		
    		$newsletter->setCreatedAt(new \DateTime());
    		$newsletter->setDesign($design);
    		$newsletter->setMandant($this->getMandant());
    		
    		$newsletter->setName('Newsletter name');
    		$newsletter->setSubject('Newsletter subject');

    		$newsletter->setReturnMail('return@newsletter.com');
    		$newsletter->setSenderMail('sender@newsletter.com');
    		$newsletter->setSenderName('Sender Name');
    		
    		return $newsletter;
    }
    
    protected function createTestSubscriber()
    {
    		$subscriber = new Subscriber();
    		
    		$subscriber->setFirstname('Firstname');
    		$subscriber->setLastname('Lastname');

    		$subscriber->setEmail('mail@subscriber.com');
    		$subscriber->setCompanyname('Subscriber Company');
    		
    		$subscriber->setLocale($this->getRequest()->getLocale());
    		$subscriber->setGender(SubscriberInterface::GENDER_MALE);
    		$subscriber->setTitle(SubscriberInterface::TITLE_FORMAL);
    		
    		return $subscriber;
    }
}