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
     * @var \Magento\Framework\App\RequestInterface 
     */
    protected $request;
    
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
     * @var \Psr\Log\LoggerInterface 
     */
    protected $logger;
    
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
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\MediaStorage\Model\File\UploaderFactory $uploader
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Filesystem\Io\File $file
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Voicyou\Avatar\Model\AddCustomerAvatarFactory $addCustomerAvatarFactory
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Filesystem\Io\File $file,
        \Psr\Log\LoggerInterface $logger,
        \Voicyou\Avatar\Model\AddCustomerAvatarFactory $addCustomerAvatarFactory
    ) {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
        $this->request  = $request;
        $this->uploader = $uploader;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
        $this->logger = $logger;
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
            if ($_FILES['customer_avatar']['error'] > 0 ){
                $ext = pathinfo($_FILES['customer_avatar']['name'], PATHINFO_EXTENSION);
                if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg'){
                    $avatarName   = $observer->getEvent()->getCustomer()->getId().".".$ext;
                    move_uploaded_file($_FILES['customer_avatar']['tmp_name'], $voicyouAvatarImages."/".$avatarName);
                    $customerData = $this->addCustomerAvatarFactory->create()->load($observer->getEvent()->getCustomer()->getId(),'customer_id');
                    if(empty($customerData->getData()))
                    {
                        $customerData = $this->addCustomerAvatarFactory->create();
                    }
                    $customerData->setCustomerId($observer->getEvent()->getCustomer()->getId());
                    $customerData->setImageName($avatarName);
                    $customerData->save();
                }
            }
        }
        catch(\Exception $e)
        {
            $this->logger->critical($e->getMessage());
        }
    }
}
