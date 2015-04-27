<?php

class Edge_AdminGridColumns_Block_Grid_Render_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if ($row->getImage() && $row->getImage() !== 'no_selection') {
            return '<img src="' . Mage::helper('catalog/image')->init($row, 'image')->resize(100) . '" alt="">';
        }
        return '';
    }
}
