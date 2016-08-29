<?php
/**
 * Magensky_Admintools
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Team
 * that is bundled with this package of Magensky.
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contact us Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 *
 * @category    Magensky
 * @package     Magensky_Admintools
 * @website   	Magensky.com
 * @Author: 	sontung.x305@gmail.com
 **/
	class Magensky_Admintools_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View {
    public function  __construct() {

        parent::__construct();
        if(Mage::helper('admintools')->isDeleteOrderActive()) {
            $message = Mage::helper('sales')->__('Are you sure you want to delete this order?');
            $this->_addButton('button_id', array(
                'label'     => Mage::helper('Sales')->__('Delete Order'),
                'onclick'   => 'deleteConfirm(\''.$message.'\', \'' . $this->getDeleteUrl() . '\')',
                'class'     => 'go'
            ), 0, 100, 'header', 'header');
        }
    }
	
    public function getDeleteUrl()
    {
        return $this->getUrl('*/deleteorder/delete', array('_current'=>true));
    }	
}
?>