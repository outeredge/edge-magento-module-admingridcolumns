<?php

class Edge_AdminGridColumns_Block_System_Config_Form_Field_GridAndColumn extends Mage_Core_Block_Html_Select
{
    protected $_grids = array();

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Render block HTML
     * @return string
     */
    public function _toHtml()
    {
        $this->_grids = array(
            'products' => 'Mage_Adminhtml_Block_Catalog_Product_Grid'
        );

        $this->setOptions(array(
            array(
                'label' => Mage::helper('adminhtml')->__('Products'),
                'value' => array(
                    array(
                        'label' => Mage::helper('adminhtml')->__('Image'),
                        'value' => $this->_getGridAndColumnValue('products', 'image')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Description'),
                        'value' => $this->_getGridAndColumnValue('products', 'description')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Short Description'),
                        'value' => $this->_getGridAndColumnValue('products', 'short_description')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Category'),
                        'value' => $this->_getGridAndColumnValue('products', 'category')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('MPN'),
                        'value' => $this->_getGridAndColumnValue('products', 'mpn')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Weight'),
                        'value' => $this->_getGridAndColumnValue('products', 'weight')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('URL Key'),
                        'value' => $this->_getGridAndColumnValue('products', 'url_key')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Special Price'),
                        'value' => $this->_getGridAndColumnValue('products', 'special_price')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Tax Class'),
                        'value' => $this->_getGridAndColumnValue('products', 'tax_class_id')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Meta Title'),
                        'value' => $this->_getGridAndColumnValue('products', 'meta_title')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Meta Keywords'),
                        'value' => $this->_getGridAndColumnValue('products', 'meta_keyword')
                    ),
                    array(
                        'label' => Mage::helper('adminhtml')->__('Meta Description'),
                        'value' => $this->_getGridAndColumnValue('products', 'meta_description')
                    )
                )
            )
        ));

        return parent::_toHtml();
    }

    protected function _getGridAndColumnValue($grid, $column)
    {
        return $this->_grids[$grid] . '::' . $column;
    }
}