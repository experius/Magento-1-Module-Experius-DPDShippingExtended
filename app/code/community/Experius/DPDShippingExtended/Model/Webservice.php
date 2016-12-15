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
 * Class Experius_DPDShippingExtended_Model_Webservice extends DPD_Shipping_Model_Webservice
 */
class Experius_DPDShippingExtended_Model_Webservice extends DPD_Shipping_Model_Webservice
{
	
	public function formatParcelShops($data){
		$shops = array();
		foreach($data as $parcelshop){
			$parcelshop = $parcelshop['pickupLocation'];
			$address = $parcelshop['address'];
			$addressPoint = $parcelshop['addressPoint'];
			$shop = array();
			$shop['parcelShopId'] = $parcelshop['pickupLocationCode'];
			$shop['company'] = $address['organisation'];
			$shop['houseNo'] = '';
			$shop['city'] = $address['town'];
			$shop['latitude'] = $addressPoint['latitude'];
			$shop['longitude'] = $addressPoint['longitude'];
			$shop['isoAlpha2'] = $address['countryCode'];
			$shop['zipCode'] = $address['postcode'];
			$shop['street'] = $address['street'];
			$shop['openLate'] = $parcelshop['openLate'];
            $shop['openSaturday'] = $parcelshop['openSaturday'];
            $shop['openSunday'] = $parcelshop['openSunday'];
			$shops[] = (object)$shop;
		}
		return (object) array('parcelShop' => (object)$shops );
	}
		
	
	
	public function getParcelShops($longitude, $latitude)
    {
    	if(Mage::getStoreConfig('carriers/dpdparcelshops/change_api')){
				
			$webserviceUrl = "https://api.dpdgroup.co.uk";
			
			$pageCount = (Mage::getStoreConfig('carriers/dpdparcelshops/result_count')) ? Mage::getStoreConfig('carriers/dpdparcelshops/result_count') : '10' ;
		
			$method = '/organisation/pickuplocation/?filter=byLatLong&latitude=' . $latitude . '&longitude=' . $longitude . '&searchPageSize=' . $pageCount . '&searchPage=1&maxDistance=10';
			
			$url = $webserviceUrl . $method;
			
			$options = array(
			    'http' => array(
			        'method'  => 'GET',
			        'Host'  => 'api.dpdgroup.co.uk',
			        'header'=>  "Content-Type: application/json\r\n" .
			                    "Accept: application/json\r\n".
			                    "Content-Length: 0"
			      )
			);
			
			$context    = stream_context_create($options);
			$result     = file_get_contents($url, false, $context);
			$response   = json_decode($result);
			$data		= json_decode($result,true);
			
			
			return $this->formatParcelShops($data['data']['results']);
			
		}else{
			parent::getParcelShops();
		}
			

    }
	
	public function getLoginResult()
    {
    	if(Mage::getStoreConfig('carriers/dpdparcelshops/change_api')){
        	return true;
		}else{
			parent::getParcelShops();
		}
    }
}
