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

        $productAttributes = array(
            array(
                'label' => Mage::helper('adminhtml')->__('Category'),
                'value' => $this->_getGridAndColumnValue('products', 'category')
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('Short Description'),
                'value' => $this->_getGridAndColumnValue('products', 'short_description')
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('Weight'),
                'value' => $this->_getGridAndColumnValue('products', 'weight')
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('Special Price'),
                'value' => $this->_getGridAndColumnValue('products', 'special_price')
            ),
            array(
                'label' => Mage::helper('adminhtml')->__('Tax Class Id'),
                'value' => $this->_getGridAndColumnValue('products', 'tax_class_id')
            )
        );

        $systemProductAttributes = array(
            'name',
            'sku',
            'status',
            'visibility',
            'category_ids',
            'required_options',
            'has_options',
            'media_gallery',
            'gallery',
            'options_container'
        );

        $attributes = Mage::getModel('catalog/product')->getAttributes();
        foreach ($attributes as $attribute) {
            if ($attribute->getAttributeId() && !in_array($attribute->getAttributeCode(), $systemProductAttributes)) {
                $productAttributes[] = array(
                    'label' => ucwords(str_replace('_', ' ', $attribute->getAttributeCode())),
                    'value' => $this->_getGridAndColumnValue('products', $attribute->getAttributeCode())
                );
            }
        }

        usort($productAttributes, function($a, $b){
            return strcmp($a['label'], $b['label']);
        });

        $this->setOptions(array(
            array(
                'label' => Mage::helper('adminhtml')->__('Products'),
                'value' => $productAttributes
            )
        ));

        return parent::_toHtml();
    }

    protected function _getGridAndColumnValue($grid, $column)
    {
        return $this->_grids[$grid] . '::' . $column;
    }
}