<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageProvider extends AbstractProvider
{
    protected $uploadDirectory;
    
    public function __construct($uploadDirectory)
    {
        if(!is_dir($uploadDirectory) && !@mkdir($uploadDirectory)){
            throw new \InvalidArgumentException("Could not create directory $uploadDirectory");
        }
        
        if(!is_writable($uploadDirectory)){
            throw new \InvalidArgumentException("No write access on directory $uploadDirectory");
        }
        
        $this->uploadDirectory = realpath($uploadDirectory);
    }
    
    public function getBlockDisplayContent(BlockInterface $block)
    {
        return '<img src="'. $block->getContent() .'">';
    }
    
    public function getBlockEditContent(BlockInterface $block)
    {
        return '<input type="file" name="block['. $block->getId() .']">';
    }
    
    public function updateBlock(BlockInterface $block, $update)
    {
        if(!$update){
            return;
        }
        
        if(!$update instanceof UploadedFile){
            throw new \InvalidArgumentException("Need instanceof Symfony\\Component\\HttpFoundation\\File\\UploadedFile");
        }
        
        if(!$update->isValid()){
            return;
        }
        
        $update->move($this->uploadDirectory, $block->getId);
    }
}