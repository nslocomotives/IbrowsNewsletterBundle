<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Block\BlockComposition;

/**
 * @Route("/overview")
 */
class NewsletterRenderingController extends AbstractHashMandantController
{
    /**
     * @Route("/show/{$mandantHash}/{newsletterId}/{subscriberId}/{context}", name="ibrows_newsletter_overview")
     */
    public function overviewAction($mandantHash, $newsletterId, $subscriberId, $context)
    {
        $this->setMandantNameByHash($mandantHash);

        $newsletter = $this->getNewsletterById($newsletterId);
        $subscriber = $this->getSubscriberById($newsletter, $subscriberId);

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