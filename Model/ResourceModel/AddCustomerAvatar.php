<?php
/**
 * Copyright © Voicyou Softwares 2017. All rights reserved.
 */
namespace Voicyou\Avatar\Model\ResourceModel;

/**
 * Class AddCustomerAvatar
 *
 * @package Voicyou\Avatar\Model\ResourceModel
 */
class AddCustomerAvatar extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
     */
    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context,
                                \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    )
    {
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->resource = $context->getResources();
        parent::__construct($context);
    }

    public function _construct()
    {
        $this->_init('voicyou_customer_avatar', 'id');
    }
}
