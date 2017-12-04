<?php
/**
 * Copyright © Voicyou Softwares 2017. All rights reserved.
 */
namespace Voicyou\Avatar\Model\ResourceModel\AddCustomerAvatar;

/**
 * Class Collection
 *
 * @package Voicyou\Avatar\Model\ResourceModel\AddCustomerAvatar
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Voicyou\Avatar\Model\AddCustomerAvatar', 'Voicyou\Avatar\Model\ResourceModel\AddCustomerAvatar');
    }
}
