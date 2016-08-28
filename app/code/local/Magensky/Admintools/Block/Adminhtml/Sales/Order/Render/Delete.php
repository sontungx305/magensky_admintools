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
class Magensky_Admintools_Block_Adminhtml_Sales_Order_Render_Delete extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $getData = $row->getData();
        $message = Mage::helper('sales')->__('Are you sure you want to delete this order?');
        $orderID = $getData['entity_id'];
        $view_link = "";
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            $view = $this->getUrl('*/sales_order/view', array('order_id' => $orderID));
            $view_link = "<a href=\"".$view."\">View</a> | ";
        }
        $delete = $this->getUrl('*/deleteorder/delete',array('order_id' => $orderID));
        $delete_link = '<a href="#" onclick="deleteConfirm(\''.$message.'\', \'' . $delete . '\')">Delete</a>';
        return $view_link.$delete_link;
    }
}
?>