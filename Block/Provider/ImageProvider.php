<?php

namespace Ibrows\Bundle\NewsletterBundle\Block\Provider;

use Ibrows\Bundle\NewsletterBundle\Model\Block\BlockInterface;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

class ImageProvider extends AbstractProvider
{
    protected $uploadDirectory;
    protected $publicPath;
    
    public function __construct($uploadDirectory, $publicPath)
    {
        if(!is_dir($uploadDirectory)){
            $filesystem = new Filesystem();
            $filesystem->mkdir($uploadDirectory);
        }
        
        if(!is_writable($uploadDirectory)){
            throw new \InvalidArgumentException("No write access on directory $uploadDirectory");
        }
        
        $this->uploadDirectory = realpath($uploadDirectory);
        $this->publicPath = $publicPath;
    }
    
    public function getBlockDisplayContent(BlockInterface $block)
    {
        if(!file_exists($this->getFilePath($block))){
            return 'No image found';
        }
        
        return '<img src="'. $this->getPublicPath($block) .'">';
    }
    
    public function getBlockEditContent(BlockInterface $block)
    {
        $string = '';
        
        if(file_exists($this->getFilePath($block))){
            $string .= '<div>'. $this->getBlockDisplayContent($block) .'</div>';
        }
        
        $string .= '
            <div><input type="file" name="block['. $block->getId() .']"></div>
        ';
        
        return $string;
    }
    
    public function updateBlock(BlockInterface $block, $update)
    {
        if(is_null($update)){
            return;
        }
        
        if(!$update instanceof UploadedFile){
            throw new \InvalidArgumentException("Need instanceof Symfony\\Component\\HttpFoundation\\File\\UploadedFile");
        }
        
        if(!$update->isValid()){
            return;
        }
        
        $update->move($this->uploadDirectory, $block->getId());
    }
    
    protected function getFilePath(BlockInterface $block)
    {
        return $this->uploadDirectory.'/'. $block->getId();
    }
    
    protected function getPublicPath(BlockInterface $block)
    {
        return $this->publicPath.'/'. $block->getId();
    }
}