<?php
/**
 * Copyright © Voicyou Softwares 2017. All rights reserved.
 */
namespace Voicyou\Avatar\Model;

/**
 * Class AddCustomerAvatar
 *
 * @package Voicyou\Avatar\Model
 */
class AddCustomerAvatar extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Voicyou\Avatar\Model\ResourceModel\AddCustomerAvatar');
    }
}
