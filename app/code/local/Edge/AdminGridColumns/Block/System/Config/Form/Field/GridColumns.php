<?php

class Edge_AdminGridColumns_Block_System_Config_Form_Field_GridColumns extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * @var Edge_AdminGridColumns_Block_System_Config_Form_Field_Grid
     */
    protected $_gridAndColumnRenderer;

    /**
     * Retrieve grid renderer
     * @return Edge_AdminGridColumns_Block_System_Config_Form_Field_Grid
     */
    protected function _getGridAndColumnRenderer()
    {
        if (!$this->_gridAndColumnRenderer) {
            $this->_gridAndColumnRenderer = $this->getLayout()->createBlock(
                'admingridcolumns/system_config_form_field_gridAndColumn', '',
                array('is_render_to_js_template' => true)
            );
            $this->_gridAndColumnRenderer->setExtraParams('style="width:500px"');
        }
        return $this->_gridAndColumnRenderer;
    }

    /**
     * Prepare to render
     */
    protected function _prepareToRender()
    {
        $this->addColumn('data', array(
            'label' => Mage::helper('adminhtml')->__('Grid & Column'),
            'renderer' => $this->_getGridAndColumnRenderer()
        ));
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('adminhtml')->__('Add Column To Grid');
    }

    /**
     * Prepare existing row data object
     *
     * @param Varien_Object
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getGridAndColumnRenderer()->calcOptionHash($row->getData('data')),
            'selected="selected"'
        );
    }
}