<?php
/**
 * Copyright © 2017 Voicyou Softwares . All rights reserved.
 */
namespace Voicyou\Avatar\Block\Avatar;

/**
 * Class Avatar
 *
 * @package Voicyou\Avatar\Block\Avatar
 */
class Avatar extends \Magento\Framework\View\Element\Template
{

    /**
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlInterface;

    /**
     *
     * @var \Magento\Customer\Model\Session 
     */
    protected $customerSession;
    
    /**
     *
     * @var \Voicyou\Avatar\Model\AddCustomerAvatar 
     */
    protected $addCustomerAvatar;
    
    /**
     *
     * @var \Magento\Store\Model\StoreManagerInterface 
     */
    protected $storeManagerInterface;
    
    /**
     * 
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\UrlInterface $urlInterface
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Voicyou\Avatar\Model\AddCustomerAvatar $addCustomerAvatar
     * @param \Magento\Store\Model\StoreManagerInterface $storeManagerInterface
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\UrlInterface $urlInterface,
        \Magento\Customer\Model\Session $customerSession,
        \Voicyou\Avatar\Model\AddCustomerAvatar $addCustomerAvatar,
        \Magento\Store\Model\StoreManagerInterface $storeManagerInterface,
        $data = []
    ) {
        $this->urlInterface = $urlInterface;
        $this->customerSession = $customerSession;
        $this->addCustomerAvatar = $addCustomerAvatar;
        $this->storeManagerInterface = $storeManagerInterface;
        parent::__construct($context, $data = []);
    }

    /**
     * 
     * @return customerId
     */
    public function getCustomerId()
    {
        return $this->customerSession->getCustomerId();
    }
    
    /**
     * 
     * @return array
     */
    public function getAvatarInfo()
    {
        $customerData = $this->addCustomerAvatar->load($this->customerSession->getCustomerId(),'customer_id');
        return $customerData->getData();
    }
    
    /**
     * 
     * @return url
     */
    public function getMediaUrl()
    {
        return $this->storeManagerInterface->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);;
    }
}