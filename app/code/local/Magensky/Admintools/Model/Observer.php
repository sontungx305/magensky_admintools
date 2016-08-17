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
 * @Date: 15/08/2016
 * @Time: 23:35
 **/
class Magensky_Admintools_Model_Observer
{
    public function showTemplatePathHints(Varien_Event_Observer $observer)
    {
        $helper				= Mage::helper('admintools');
        $isActive			= $helper->isPathHintActive();
        $tp					= Mage::app()->getRequest()->getParam('tp');
        $code				= $helper->getConfig('template_path_hint','code');
        $show_block         = $helper->getConfig('template_path_hint','show_block');

        if ($isActive && isset($tp) && $tp == $code) {
            /* @var $block Mage_Core_Block_Abstract */
            $block     = $observer->getBlock();
            $transport = $observer->getTransport();
            $fileName  = $block->getTemplateFile();
            $thisClass = get_class($block);
            if ($fileName) {
                $preHtml = '<div style="position:relative; border:1px dotted red; margin:6px 2px; padding:18px 2px 2px 2px; zoom:1;">
	<div style="position:absolute; left:0; top:0; padding:2px 5px; background:red; color:white; font:normal 11px Arial;
	text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=\'999\'"
	onmouseout="this.style.zIndex=\'998\'" title="' . $fileName . '">' . $fileName . '</div>';
                if($show_block) {
                    $preHtml .= '<div style="position:absolute; right:0; top:0; padding:2px 5px; background:red; color:blue; font:normal 11px Arial;
		text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=\'999\'" onmouseout="this.style.zIndex=\'998\'"
		title="' . $thisClass . '">' . $thisClass . '</div>';
                }
                $postHtml = '</div>';
            } else {
                $preHtml  = null;
                $postHtml = null;
            }
            $html = $transport->getHtml();
            $html = $preHtml . $html . $postHtml;
            $transport->setHtml($html);
        }
    }
}

