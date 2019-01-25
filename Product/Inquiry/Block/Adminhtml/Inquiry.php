<?php

namespace Product\Inquiry\Block\Adminhtml;

class Inquiry extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        $this->_controller = 'adminhtml_inquiry';
        $this->_blockGroup = 'Product_Inquiry';
        $this->_headerText = __('Inquiry');
        $this->_addButtonLabel = __('Add New Inquiry');
        parent::_construct();
        if ($this->_isAllowedAction('Product_Inquiry::save')) {
            $this->buttonList->update('add', 'label', __('Add New Inquiry'));
        } else {
            $this->buttonList->remove('add');
        }
        
        $this->buttonList->remove('add');
    }

    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
