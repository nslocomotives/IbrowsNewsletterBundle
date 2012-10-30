<?php

namespace Ibrows\Bundle\NewsletterBundle\Controller;

use Ibrows\Bundle\NewsletterBundle\Service\orm\DesignManager;
use Ibrows\Bundle\NewsletterBundle\Service\orm\NewsletterManager;
use Ibrows\Bundle\NewsletterBundle\Service\orm\MandantManager;
use Ibrows\Bundle\NewsletterBundle\Service\TemplateManager;
use Ibrows\Bundle\NewsletterBundle\Service\ClassManager;
use Ibrows\Bundle\NewsletterBundle\Service\RendererManager;
use Ibrows\Bundle\NewsletterBundle\Service\BlockProviderManager;

use Ibrows\Bundle\NewsletterBundle\Model\Newsletter\NewsletterInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Mandant\MandantInterface;
use Ibrows\Bundle\NewsletterBundle\Model\User\MandantUserInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Subscriber\SubscriberInterface;
use Ibrows\Bundle\NewsletterBundle\Model\Log\LogInterface;

use Ibrows\Bundle\NewsletterBundle\Annotation\Wizard\WizardActionAnnotationHandler;

use Ibrows\Bundle\NewsletterBundle\Renderer\Bridge\BridgeMethodsHelper;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

abstract class AbstractController extends Controller
{
    protected function getParameter($name)
    {
        return $this->container->getParameter($name);
    }

    protected function getRendererBridge()
    {
        return $this->get($this->getParameter('ibrows_newsletter.serviceid.rendererbridge'));
    }

    /**
     * @param integer $newsletterId
     * @param string $message
     * @param integer $subscriberId
     */
    protected function addNewsletterReadLog($newsletterId, $message = 'Newsletter was read', $subscriberId = null)
    {
        $readlogClassname = $this->getClassManager()->getModel('readlog');

        /* @var LogInterface $readlog */
        $readlog = new $readlogClassname();

        $readlog
            ->setNewsletterId($newsletterId)
            ->setSubscriberId($subscriberId)
            ->setMessage($message)
        ;

        $this->getObjectManager()->persist($readlog);
        $this->getObjectManager()->flush();
    }

    protected function getMandantNameByHash($hash)
    {
        foreach($this->getParameter('ibrows_newsletter.mandants') as $mandantName => $mandantHash){
            if($hash == $mandantHash){
                return $mandantName;
            }
        }

        throw new InvalidConfigurationException("Update configuration with mandanthash '$hash'");
    }

    /**
     * @return MandantManager
     */
    protected function getMandantManager()
    {
        return $this->get('ibrows_newsletter.mandant_manager');
    }
    
    /**
     * @return ObjectManager
     */
    protected function getObjectManager()
    {
    		return $this->getMandantManager()->getObjectManager($this->getMandantName());
    }
    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->get('session');
    }

    /**
     * @return BridgeMethodsHelper
     */
    protected function getBridgeMethodsHelper()
    {
        return $this->get('ibrows_newsletter.rendererbridge.methodshelper');
    }
    
    /**
     * @return string
     * @throws InvalidConfigurationException
     */
    protected function getMandantName()
    {
        $user = $this->getUser();

        if(!$user instanceof MandantUserInterface){
            throw new InvalidConfigurationException('Make sure you are authenticated and your user class implements the IbrowsNewsletter UserInterface');
        }

        return $user->getMandant();
    }

    /**
     * @return Collection
     */
    protected function getBlocks()
    {
        return $this->getMandant()->getBlocks();
    }

    /**
     * @return MandantInterface
     */
    protected function getMandant()
    {
        return $this->getMandantManager()->get($this->getMandantName());
    }

    /**
     * @return TemplateManager
     */
    protected function getTemplateManager()
    {
        return $this->get('ibrows_newsletter.template_manager');
    }
    
    /**
     * @return ClassManager
     */
    protected function getClassManager()
    {
        return $this->get('ibrows_newsletter.class_manager');
    }
    
    /**
     * @return BlockProviderManager
     */
    protected function getBlockProviderManager()
    {
        return $this->get('ibrows_newsletter.block_provider_manager');
    }
    
    /**
     * @return RendererManager
     */
    protected function getRendererManager()
    {
        return $this->get('ibrows_newsletter.renderer_manager');
    }
    
    /**
     * @return NewsletterManager
     */
    protected function getNewsletterManager()
    {
        return $this->getMandantManager()->getNewsletterManager($this->getMandantName());
    }
    
    /**
     * @return DesignManager
     */
    protected function getDesignManager()
    {
        return $this->getMandantManager()->getDesignManager($this->getMandantName());
    }
    
    /**
     * @return WizardActionAnnotationHandler
     */
    protected function getWizardActionAnnotationHandler()
    {
        return $this->get('ibrows_newsletter.annotation.wizard.handler');
    }
    
    /**
     * @return true|Response
     */
    protected function getWizardActionValidation()
    {
        return $this->getWizardActionAnnotationHandler()->getValidation();
    }
    
    /**
     * @param NewsletterInterface $newsletter
     * @return AbstractController
     */
    protected function setNewsletter(NewsletterInterface $newsletter = null)
    {
        $session = $this->getSession();
        
        if(is_null($newsletter)){
            $session->set('ibrows_newsletter.wizard.newsletterid', null);
            return $this;
        }
        
        $mandantName = $this->getMandantName();
        $this->getMandantManager()->persistNewsletter($mandantName, $newsletter);
        $session->set('ibrows_newsletter.wizard.newsletterid', $newsletter->getId());
        
        return $this;
    }

    /**
     * @param NewsletterInterface $newsletter
     * @param integer $subscriberId
     * @return SubscriberInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getSubscriberById(NewsletterInterface $newsletter, $subscriberId)
    {
        foreach($newsletter->getSubscribers() as $newsletterSubscriber){
            if($newsletterSubscriber->getId() == $subscriberId){
                return $newsletterSubscriber;
            }
        }

        throw $this->createNotFoundException("Subscriber $subscriberId not found in newsletter #". $newsletter->getId());
    }

    /**
     * @param integer $id
     * @return NewsletterInterface
     * @throws NotFoundException
     */
    protected function getNewsletterById($id)
    {
        $newsletter = $this->getNewsletterManager()->get($id);
        
        if(!$newsletter){
            throw $this->createNotFoundException("Newsletter with id $id not found");
        }
        
        return $newsletter;
    }

    /**
     * @return SubscriberInterface[]
     */
    protected function getSubscribers()
    {
        return $this->getMandant()->getSubscribers();
    }
    
    /**
     * @param string $hash
     * @return NewsletterInterface
     * @throws NotFoundException
     */
    protected function getNewsletterByHash($hash)
    {
        $newsletter = $this->getNewsletterManager()->getByHash($hash);
        
        if(!$newsletter){
            throw $this->createNotFoundException("Newsletter with hash $hash not found");
        }
        
        return $newsletter;
    }

    /**
     * @param NewsletterInterface $newsletter
     * @param string $hash
     * @return SubscriberInterface
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    protected function getSubscriberByHash(NewsletterInterface $newsletter, $hash)
    {
        $subscriber = null;

        foreach($newsletter->getSubscribers() as $newsletterSubscriber){
            if($newsletterSubscriber->getHash() == $hash){
                return $newsletterSubscriber;
            }
        }

        throw $this->createNotFoundException("Subscriber with hash $hash not found in newsletter #". $newsletter->getId());
    }
    
    /**
     * @return NewsletterInterface
     * @throws NotFoundException
     */
    protected function getNewsletter()
    {
        $newsletterId = $this->getSession()->get('ibrows_newsletter.wizard.newsletterid', null);
        
        if(is_null($newsletterId)){
            return null;
        }
        
        return $this->getNewsletterById($newsletterId);
    }
    
    /**
     * @see Symfony\Bundle\FrameworkBundle\Controller.Controller::render()
     */
	public function render($view, array $parameters = array(), Response $response = null)
    {
        $basetemplate = $this->getTemplateManager()->getBaseTemplate();
        $parameters = array_merge($parameters, array(
            'basetemplate' => $basetemplate,
            'tinymceCustomButtons' => json_encode($this->getBridgeMethodsHelper()->getMethodDefinitions())
        ));
    		
        return $this->container->get('templating')->renderResponse($view, $parameters, $response);
    }
}