<?php

class Edge_AdminGridColumns_Block_Grid_Render_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $id = $row->getEntityId() ? $row->getEntityId() : $row->getId();

        $modelClass = get_class($row);

        $entity = new $modelClass();
        $entity->load($id);

        $categories = array();

        $categoryIds = $entity->getCategoryIds();
        foreach ($categoryIds as $categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $categories[] = $category->getName();
        }

        return implode(',<br>', $categories);
    }
}
