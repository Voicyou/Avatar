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
     * @var \Magento\Framework\View\Element\Template\Contex
     */
    protected $context;

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
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Voicyou\Avatar\Model\AddCustomerAvatar $addCustomerAvatar
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Voicyou\Avatar\Model\AddCustomerAvatar $addCustomerAvatar,
        $data = []
    ) {
        $this->context = $context;
        $this->customerSession = $customerSession;
        $this->addCustomerAvatar = $addCustomerAvatar;
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
        return $this->context->getStoreManager()->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);;
    }
}
