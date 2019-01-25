<?php

namespace Product\Inquiry\Model\ResourceModel\Inquiry;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    public function _construct()
    {
        $this->_init(
            'Product\Inquiry\Model\Inquiry',
            'Product\Inquiry\Model\ResourceModel\Inquiry'
        );
    }
}
