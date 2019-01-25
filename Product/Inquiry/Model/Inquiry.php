<?php

namespace Product\Inquiry\Model;

class Inquiry extends \Magento\Framework\Model\AbstractModel
{

    public function _construct()
    {
        $this->_init('Product\Inquiry\Model\ResourceModel\Inquiry');
    }
}
