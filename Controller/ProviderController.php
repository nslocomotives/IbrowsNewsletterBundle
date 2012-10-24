<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Entity\Block;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/provider")
 */
class ProviderController extends AbstractController
{
    /**
	 * @Route("/view/edit", name="ibrows_newsletter_provider_view_edit")
	 */
	public function editViewAction()
	{
        $request = $this->getRequest();
        
        if(!$request->isXmlHttpRequest()){
            throw $this->createNotFoundException();
        }
        
        $data = $request->request->all();
        
        if(!isset($data['provider'])){
            throw $this->createNotFoundException("No provider set");
        }
        
        if(!isset($data['name'])){
            throw $this->createNotFoundException("No name set");
        }
        
        if(!isset($data['option']) OR !is_array($data['option'])){
            $data['option'] = array();
        }
        
        $provider = $this->getBlockProviderManager()->get($data['provider']);
        $newsletter = $this->getNewsletter();
        
        $blockClassName = $this->getClassManager()->getModel('block');
        
        $block = new $blockClassName();
        $block->setName($data['name']);
        $block->setProviderOptions($data['option']);
        $block->setProviderName($data['provider']);
        $block->setPosition(1);
        
        $provider->initialize($block, $blockClassName);
        $newsletter->addBlock($block);
        
        $this->getMandantManager()->persistNewsletter($this->getMandant()->getName(), $newsletter);
        
        $json = array(
            'html' => $provider->getBlockEditContent($block),
        );

        $response = new Response(json_encode($json));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
	}
}