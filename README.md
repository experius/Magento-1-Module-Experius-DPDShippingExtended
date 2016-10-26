# Magento 1 Module Experius DPDShipping Extended

This module extends the DPD_Shipping module with the following two functionalities:

 - Disable the ParcelShops shippingmethod based on the current quote. (If a product in the quote has attribute value true then the method will be disabled, the attribute is based on the configured atttribute code)
 - Use the DPD UK API (https://api.dpdgroup.co.uk) to find ParcelShops (make sure you enable the shipping method for the UK)
