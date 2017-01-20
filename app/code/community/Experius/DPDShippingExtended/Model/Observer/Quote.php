<?php
/**
 * Created by Experius
 *
 * @package      Experius
 * @subpackage   DPDShippingExtended
 * @category     Checkout
 * @author       Lewis Voncken (Experius)
 */
/**
 * Class Experius_DPDShippingExtended_Model_Observer_Quote
 */
class Experius_DPDShippingExtended_Model_Observer_Quote
{

	public function salesQuoteItemCollectionLoadAfter(Varien_Event_Observer $observer) {
		$attributeCode = Mage::getStoreConfig('carriers/dpdparcelshops/disable_attribute');
    	if($attributeCode && ($observer->getEvent()->getCollection() instanceof Mage_Sales_Model_Resource_Quote_Item_Collection) ) {
			$items = $observer->getEvent()->getCollection()->getData();
			Mage::getSingleton('core/session')->setData('disable_dpdpickup', false);
			foreach($items as $item){
		        if(key_exists('exclude_dpdpickup',$item) && $item['exclude_dpdpickup']) {
					Mage::getSingleton('core/session')->setData('disable_dpdpickup', true);
					break;
				}	
			}
		}
	}
	
	public function setQuoteAttribute($observer)
    {
    	$attributeCode = Mage::getStoreConfig('carriers/dpdparcelshops/disable_attribute');
    	if($attributeCode){
	        $item = $observer->getEvent()->getQuoteItem();
            $productId = $item->getProductId() ;
            $resource = Mage::getResourceModel('catalog/product');
            $value = $resource->getAttributeRawValue($productId, $attributeCode, Mage::app()->getStore());
	        $item->setData('exclude_dpdpickup',$value);
	        return $this;
    	}
    }
}
