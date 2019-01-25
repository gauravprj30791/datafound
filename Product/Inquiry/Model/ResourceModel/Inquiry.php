<?php

namespace Product\Inquiry\Model\ResourceModel;

class Inquiry extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function _construct()
    {
        $this->_init('product_inquiry', 'inquiry_id');
    }
}
