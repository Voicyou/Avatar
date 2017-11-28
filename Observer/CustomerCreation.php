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
    protected $customerFactory

    /**
    * @param \Magento\Framework\ObjectManagerInterface $objectManager
    */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
        $this->_layout = $context->getLayout();
        $this->_request = $context->getRequest();
        $this->_objectManager = $objectManager;
        $this->customerFactory = $customerFactory;
    }

    /**
    * @param \Magento\Framework\Event\Observer $observer
    * @return void
    */
    public function execute(EventObserver $observer)
    {
      $customerData = $this->customerFactory->create()->load($observer->getEvent()->getCustomer()->getId());
      echo "<pre>";
      die(print_r($customerData->getData()));
      die(print_r($observer->getEvent()->getCustomer()->getCustomAttribute('promotion_code')));
        echo "Do your operaiton here";
        die('reached the end here so please ignore this test here');
    }
}
