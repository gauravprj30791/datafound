<?php

namespace Product\Inquiry\Block\Adminhtml\Inquiry;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    public $collectionFactory;
    public $inquiry;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Product\Inquiry\Model\Inquiry $inquiry,
        \Product\Inquiry\Model\ResourceModel\Inquiry\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->inquiry = $inquiry;
        parent::__construct($context, $backendHelper, $data);
    }

    public function _construct()
    {
        parent::_construct();
        $this->setId('inquiryGrid');
        $this->setDefaultSort('inquiry_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    public function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    public function _prepareColumns()
    {
        $this->addColumn(
            'inquiry_id',
            [
            'header'    => __('ID'),
            'index'     => 'inquiry_id',
            ]
        );
        
        $this->addColumn('product_id', ['header' => __('Product Id'), 'index' => 'product_id']);
        $this->addColumn('product_name', ['header' => __('Product Name'), 'index' => 'product_name']);
        $this->addColumn('product_sku', ['header' => __('Product SKU'), 'index' => 'product_sku']);
        $this->addColumn('first_name', ['header' => __('First Name'), 'index' => 'first_name']);
        $this->addColumn('last_name', ['header' => __('Last Name'), 'index' => 'last_name']);
        
        $this->addColumn(
            'published_at',
            [
                'header' => __('Published On'),
                'index' => 'published_at',
                'type' => 'date',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'index' => 'created_at',
                'type' => 'datetime',
                'header_css_class' => 'col-date',
                'column_css_class' => 'col-date'
            ]
        );
        
        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', ['inquiry_id' => $row->getId()]);
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
