<?php
/**
 * Copyright © 2017 Voicyou Softwares . All rights reserved.
 */
namespace Voicyou\Avatar\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class CustomerCreation
 *
 * @package Voicyou\Avatar\Observer
 */
class CustomerCreation implements ObserverInterface
{
    
    /**
     *
     * @var \Magento\Framework\View\Element\Context 
     */
    protected $context;

    /**
     *
     * @var \Magento\Framework\App\RequestInterface 
     */
    protected $_request;
    
    /**
     *
     * @var \Magento\Framework\View\LayoutInterface 
     */
    protected $_layout;
    
    /**
     *
     * @var \Magento\Framework\ObjectManagerInterface 
     */
    protected $_objectManager = null;
    
    /**
     *
     * @var \Magento\Customer\Model\CustomerFactory 
     */
    protected $customerFactory;

    /**
     *
     * @var \Magento\MediaStorage\Model\File\UploaderFactory 
     */
    protected $uploader;
    
    /**
     *
     * @var \Magento\Framework\Filesystem 
     */
    protected $fileSystem;
    
    /**
     *
     * @var \Magento\Framework\Filesystem\Io\File 
     */
    protected $file;
    
    /**
     *
     * @var \Voicyou\Avatar\Model\AddCustomerAvatarFactory 
     */
    protected $addCustomerAvatarFactory;
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploader
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Filesystem\Io\File $file
     * @param \Voicyou\Avatar\Model\AddCustomerAvatarFactory $addCustomerAvatarFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Filesystem\Io\File $file,
        \Voicyou\Avatar\Model\AddCustomerAvatarFactory $addCustomerAvatarFactory
    ) {
        $this->context = $context;
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
        $this->uploader = $uploader;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
        $this->addCustomerAvatarFactory = $addCustomerAvatarFactory;
    }

    /**
    * @param \Magento\Framework\Event\Observer $observer
    * @return void
    */
    public function execute(EventObserver $observer)
    {
        try{
            $voicyouAvatarImages = $this->fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('voicyouavatars/');
            $this->file->checkAndCreateFolder($voicyouAvatarImages);
            $uploader = $this->uploader->create(['fileId' => 'customer_avatar']);
            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
            $uploader->setAllowRenameFiles(false);
            $uploader->setFilesDispersion(false);
            $ext = $uploader->getFileExtension();
            $avatarName = $observer->getEvent()->getCustomer()->getId().".".$ext;
            $uploader->save($voicyouAvatarImages,$avatarName);
            $customerData = $this->addCustomerAvatarFactory->create()->load($observer->getEvent()->getCustomer()->getId(),'customer_id');
            if(empty($customerData->getData()))
            {
                $customerData = $this->addCustomerAvatarFactory->create();
            }
            $customerData->setCustomerId($observer->getEvent()->getCustomer()->getId());
            $customerData->setImageName($avatarName);
            $customerData->save();
        }
        catch(\Exception $e)
        {
            $this->context->getLogger()->critical($e->getMessage());
        }
    }
}
