<?php

class Edge_AdminGridColumns_Model_Observer
{
    protected $_after;

    public function addColumnsToGrid(Varien_Event_Observer $observer)
    {
        $gridAndColumns = Mage::helper('admingridcolumns')->getGridAndColumns();
        if (empty($gridAndColumns['grid'])) {
            return;
        }

        $block = $observer->getEvent()->getBlock();
        $blockClass = get_class($block);
        if (!isset($gridAndColumns['grid'][$blockClass])) {
            return;
        }

        $this->_after = $this->_getBlockAfter($blockClass);
        foreach ($gridAndColumns['grid'][$blockClass] as $column) {
            $this->_addColumnToBlock($block, $column);
        }
    }

    protected function _getBlockAfter($blockClass)
    {
        switch ($blockClass) {
            case 'Mage_Adminhtml_Block_Catalog_Product_Grid':
                return 'sku';
        }
    }

    protected function _addColumnToBlock($block, $column)
    {
        $columnTitle = str_replace('_', ' ', $column);
        $settings = array(
            'header' => Mage::helper('adminhtml')->__(ucwords($columnTitle)),
            'index'  => $column
        );

        switch ($column) {
            case 'image':
                $fieldSettings = array(
                    'filter' => false,
                    'searchable' => false,
                    'renderer' => 'admingridcolumns/grid_render_image'
                );
                break;

            case 'category':
                $categoryOptions = array();
                $categories = Mage::getResourceModel('catalog/category_collection')
                    ->addAttributeToSelect('name')
                    ->addFieldToFilter('level', array('nin' => array(0,1)));

                foreach ($categories as $category) {
                    $categoryOptions[$category->getEntityId()] = $category->getName();
                }

                $fieldSettings = array(
                    'type' => 'options',
                    'options' => $categoryOptions,
                    'renderer' => 'admingridcolumns/grid_render_category',
                    'filter_condition_callback' => array($this, 'filterCallback')
                );
                break;

            case 'special_price':
                $storeId = (int) Mage::app()->getRequest()->getParam('store', 0);
                $store = Mage::app()->getStore($storeId);
                $fieldSettings = array(
                    'type' => 'price',
                    'currency_code' => $store->getBaseCurrency()->getCode(),
                );
                break;

            case 'tax_class_id':
                $fieldSettings = array(
                    'type' => 'options',
                    'options' => Mage::getSingleton('tax/class')->getCollection()->toOptionHash()
                );
                break;

            default:
                $attribute = Mage::getModel('eav/entity_attribute')
                    ->getCollection()
                    ->addFieldToFilter('attribute_code', array('eq' => $column))
                    ->getFirstItem();

                if ($attribute->getAttributeId()) {
                    if ($attribute->usesSource()) {
                        $options = array();
                        foreach ($attribute->getSource()->getAllOptions() as $option){
                            $options[$option['value']] = $option['label'];
                        }

                        $fieldSettings = array(
                            'type'    => 'options',
                            'options' => $options
                        );
                    }
                    else {
                        switch ($attribute->getBackendType()) {
                            case 'datetime':
                                $fieldSettings = array(
                                    'type'      => 'datetime',
                                    'gmtoffset' => true
                                );
                                break;
                        }
                    }
                }
                break;
        }

        if (isset($fieldSettings)) {
            $settings = array_merge($settings, $fieldSettings);
        }

        if ($column === 'image') {
            $block->addColumn('edge_admingridcolumns_' . $column, $settings);
        } else {
            $block->addColumnAfter('edge_admingridcolumns_' . $column, $settings, $this->_after);
            $this->_after = 'edge_admingridcolumns_' . $column;
        }
    }

    public function filterCallback($collection, $column)
    {
        $value = $column->getFilter()->getValue();

        switch ($column->getIndex()) {
            case 'category':
                $category = Mage::getModel('catalog/category')->load($value);
                $collection->addCategoryFilter($category);
                break;
        }

        return $collection;
    }

    public function addFieldsToCollection(Varien_Event_Observer $observer)
    {
        $gridAndColumns = Mage::helper('admingridcolumns')->getGridAndColumns();
        if (empty($gridAndColumns['collection'])) {
            return;
        }

        $collection = $observer->getEvent()->getCollection();
        $collectionClass = get_class($collection);
        if (!isset($gridAndColumns['collection'][$collectionClass])) {
            return;
        }

        foreach ($gridAndColumns['collection'][$collectionClass] as $field) {
            $this->_addFieldToCollection($collection, $field);
        }
    }

    protected function _addFieldToCollection($collection, $field)
    {
        switch ($field) {
            default:
                $collection->addAttributeToSelect($field);
                break;
        }
    }
}