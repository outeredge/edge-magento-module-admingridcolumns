<?php

class Edge_AdminGridColumns_Block_Grid_Render_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if ($row->getImage() && $row->getImage() !== 'no_selection') {
            try {
                return '<img src="' . Mage::helper('edge/image')->setSize(100)->getImage('catalog/product' . $row->getImage()) . '" alt="">';
            } catch(exception $e) {
                Mage::log($e->getMessage() . " - Rendering image for product ID: " . $row->getId(), null, 'admin_image.log');
            }
        }
        return '';
    }
}
