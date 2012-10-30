<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Ibrows\Bundle\NewsletterBundle\Block\BlockComposition;

/**
 * @Route("/overview")
 */
class NewsletterRenderingController extends AbstractHashMandantController
{
    /**
     * @Route("/show/{mandantHash}/{newsletterHash}/{subscriberHash}/{context}", name="ibrows_newsletter_render_overview")
     */
    public function showAction($mandantHash, $newsletterHash, $subscriberHash, $context)
    {
        $this->setMandantNameByHash($mandantHash);

        $newsletter = $this->getNewsletterByHash($newsletterHash);
        $subscriber = $this->getSubscriberByHash($newsletter, $subscriberHash);

        $renderer = $this->getRendererManager()->get($this->getMandant()->getRendererName());

        $bridgeServiceId = $this->container->getParameter('ibrows_newsletter.rendererbridgeserviceid');
        $bridge = $this->get($bridgeServiceId);

        $blockVariables = array(
            'context' => $context,
            'mandant' => $this->getMandant(),
            'newsletter' => $newsletter,
            'subscriber' => $subscriber,
            'bridge' => $bridge,
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
}