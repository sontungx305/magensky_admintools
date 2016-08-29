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

class Magensky_Admintools_Adminhtml_DeleteorderController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('deleteorder/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}
	public function indexAction() {
		$this->_initAction()->renderLayout();
	}
	public function deleteAction() {
        $order_id = $this->getRequest()->getParam("order_id");
        if(!empty($order_id) && Mage::helper('admintools')->isDeleteOrderActive()) {
            $increment_id = Mage::getModel('sales/order')->load($order_id)->getRealOrderId();
            if($this->_delete($order_id)) {
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('admintools')->__(
                    'The order #%s were successfully deleted',$increment_id
                ));
            }
        }
        $this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
	}
    public function massDeleteAction() {
       $order_ids = $this->getRequest()->getParam("order_ids");
        if(Mage::helper('admintools')->isDeleteOrderActive()) {
            if(is_array($order_ids)){
                try {
                    $_delete_total = 0;
                    $_cannot_delete = '';
                    foreach($order_ids as $order_id) {
                        if($this->_delete($order_id)){
                            $_delete_total++;
                        }else {
                            $_cannot_delete .= $order_id.', ';
                        }
                    }
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('admintools')->__(
                        'Total of %d record(s) were successfully deleted', $_delete_total
                    ));
                    if(!empty($_cannot_delete)) {
                        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('admintools')->__(
                            'Can\'t delete those record(s) : %s', $_cannot_delete
                        ));
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }else {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
            }
        }
        $this->_redirectUrl(Mage::helper('adminhtml')->getUrl('adminhtml/sales_order/index'));
    }
	
	public function _delete($order_id){

	    /*$resource = Mage::getSingleton('core/resource');
        $delete = $resource->getConnection('core_read');
        $order_table = $resource->getTableName('sales_flat_order_grid');
        $invoice_table = $resource->getTableName('sales_flat_invoice_grid');
        $shipment_table = $resource->getTableName('sales_flat_shipment_grid');
        $creditmemo_table = $resource->getTableName('sales_flat_creditmemo_grid');
		$sql = "DELETE FROM  " . $order_table . " WHERE entity_id = " . $order_id . ";";
        $delete->query($sql);
		$sql = "DELETE FROM  " . $invoice_table . " WHERE order_id = " . $order_id . ";";
        $delete->query($sql);
		$sql = "DELETE FROM  " . $shipment_table . " WHERE order_id = " . $order_id . ";";
        $delete->query($sql);
		$sql = "DELETE FROM  " . $creditmemo_table . " WHERE order_id = " . $order_id . ";";
        $delete->query($sql);*/

        $order = Mage::getModel('sales/order')->load($order_id);
        if(!empty($order->getId())) {
            $invoices = $order->getInvoiceCollection();
            if(count($invoices)) {
                foreach ($invoices as $invoice){
                    $invoice->delete();
                }
            }
            $creditmemos = $order->getCreditmemosCollection();
            if(count($creditmemos)) {
                foreach ($creditmemos as $creditnote){
                    $creditnote->delete();
                }
            }
            $shipments = $order->getShipmentsCollection();
            if(count($shipments)) {
                foreach ($shipments as $shipment){
                    $shipment->delete();
                }
            }

            if($order->delete()){
                return true;
            }else {
                return false;
            }
        }else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('The order (id : %s) no longer exists',$order_id));
        }
	}
	
}