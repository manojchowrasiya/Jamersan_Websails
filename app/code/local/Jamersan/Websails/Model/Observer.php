<?php
require_once (Mage::getModuleDir('', 'Jamersan_Websails') . DS . 'lib' . DS .'magmi/inc/magmi_defs.php');
require_once("magmi_datapump.php");

class Jamersan_Websails_Model_Observer {
    public function run() {
    	//initialize datapump
    	$dp = Magmi_DataPumpFactory::getDataPumpInstance("productimport");
		//open csv
		$file = Mage::getModuleDir('', 'Jamersan_Websails') . DS . 'data' . DS .'import.csv';
		$csv = new Varien_File_Csv();
		$data = $csv->getData($file);

		for($i=1; $i<count($data); $i++) {
			$row = $data[$i];
			
			//see if product exist to define operation type
			if (Mage::getModel('catalog/product')->load($row[5])->getName() != null) {
				$action = 'update';
			} else {
				$action = 'create';
			}

			$dp->beginImportSession("default",$action);

	        //type, sku, name, config_attributes, price, weight, size, attr, visibility, qty, associated, super_attribute_pricing, manufacturer
	         $testitem=array("type" => $row[3], "sku" => $row[5], "name" => $row[7], "config_attributes" => $row[16], "price" => $row[27], "weight" => $row[29], "size" => $row[31], "attr" => $row[32], "visibility" => $row[34], "qty" => $row[48], "manufacturer" => $row[88]);
	         // Now ingest item into magento
	         $dp->ingest($testitem);
	        
	        // End import Session
	        $dp->endImportSession(); 
	    }
		 
    }
}