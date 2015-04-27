<?php

class Edge_AdminGridColumns_Helper_Data extends Mage_Core_Helper_Abstract
{
    public $_gridAndColumns;

    public function getGridAndColumns()
    {
        if (!$this->_gridAndColumns) {
            $gridAndColumns = array(
                'grid' => array(),
                'collection' => array()
            );
            $data = unserialize(Mage::getStoreConfig('admingridcolumns/data/columns'));
            if (!empty($data)) {
                foreach ($data as $column) {
                    $columnData = explode('::', $column['data']);
                    if (!isset($gridAndColumns['grid'][$columnData[0]])) {
                        $gridAndColumns['grid'][$columnData[0]] = array();
                    }

                    $collectionClass = $this->_getBlockCollection($columnData[0]);
                    if (!isset($gridAndColumns['collection'][$collectionClass])) {
                        $gridAndColumns['collection'][$collectionClass] = array();
                    }
                    $gridAndColumns['grid'][$columnData[0]][] = $columnData[1];
                    $gridAndColumns['collection'][$collectionClass][] = $columnData[1];
                }
            }
            $this->_gridAndColumns = $gridAndColumns;
        }

        return $this->_gridAndColumns;
    }

    protected function _getBlockCollection($blockClass)
    {
        switch ($blockClass) {
            case 'Mage_Adminhtml_Block_Catalog_Product_Grid';
                return 'Mage_Catalog_Model_Resource_Product_Collection';
        }

        return 'scott';
    }
}