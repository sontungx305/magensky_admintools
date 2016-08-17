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
class Magensky_Admintools_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function isPathHintActive() {
		return $this->getConfig('template_path_hint','active');
	}
	public function getConfig($group, $field)
	{
		return Mage::getStoreConfig('admintools/' . $group . '/' . $field, Mage::app()->getStore());
	}
}
?>
