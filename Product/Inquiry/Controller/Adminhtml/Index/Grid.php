<?php

namespace Product\Inquiry\Controller\Adminhtml\Index;

class Grid extends \Magento\Customer\Controller\Adminhtml\Index
{

    public function execute()
    {
        $this->_view->loadLayout(false);
        $this->_view->renderLayout();
    }
}
