<?php

namespace Voicyou\Avatar\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;


class CustomerCreation implements ObserverInterface
{
    protected $_request;
    protected $_layout;
    protected $_objectManager = null;
    protected $_customerGroup;
    protected $customerFactory;
    protected $request;
    protected $uploader;
    protected $fileSystem;
    protected $file;    
    /**
    * @param \Magento\Framework\ObjectManagerInterface $objectManager
    */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\MediaStorage\Model\File\UploaderFactory $uploader,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Filesystem\Io\File $file
    ) {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
        $this->request  = $request;
        $this->uploader = $uploader;
        $this->fileSystem = $fileSystem;
        $this->file = $file;
    }

    /**
    * @param \Magento\Framework\Event\Observer $observer
    * @return void
    */
    public function execute(EventObserver $observer)
    {
        $voicyouAvatarImages = $this->fileSystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA)->getAbsolutePath('voicyouavatars/');
        $this->file->checkAndCreateFolder($voicyouAvatarImages);
        $ext = pathinfo($_FILES['customer_avatar']['name'], PATHINFO_EXTENSION);
        $avatarName   = $observer->getEvent()->getCustomer()->getId().".".$ext;
        $_FILES['customer_avatar']['name'] = $avatarName;
        $uploader = $this->uploader->create(['fileId' => 'customer_avatar']);
        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
        $uploader->setAllowRenameFiles(false);
        $uploader->setFilesDispersion(false);
        $uploader->save($voicyouAvatarImages);
        //die("Name:".$avatarName);
        /*echo "<pre>";
      die(print_r($_FILES));
      die(print_r($this->request->getParams()));
      $customerData = $this->customerFactory->create()->load($observer->getEvent()->getCustomer()->getId());
      echo "<pre>";
      die(print_r($customerData->getData()));
      die(print_r($observer->getEvent()->getCustomer()->getCustomAttribute('promotion_code')));
      echo "Do your operaiton here";
      die('reached the end here so please ignore this test here');*/
        return $this;
    }
}
