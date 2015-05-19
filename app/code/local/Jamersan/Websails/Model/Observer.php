<?php
require_once (Mage::getModuleDir('', 'Jamersan_Websails') . DS . 'lib' . DS .'magmi/inc/magmi_defs.php');
require_once("magmi_datapump.php");

class Jamersan_Websails_Model_Observer {
    public function run() {
// create a Product import Datapump using Magmi_DatapumpFactory
        $dp=Magmi_DataPumpFactory::getDataPumpInstance("productimport");


        // Begin import session with a profile & running mode, here profile is "default" & running mode is "create".
        // Available modes: "create" creates and updates items, "update" updates only, "xcreate creates only.
        // Important: for values other than "default" profile has to be an existing magmi profile 
        $dp->beginImportSession("default","create");

        //loop over 100 fake items
        for($i=0;$i<100;$i++)
        {
         // Here we define a single "simple" item, with name, sku,price,attribute_set,store,description
         // some varations on sku , name & description based on loop index
         $testitem=array("name"=>"test item $i","sku"=>"SKU". str_pad((int) $i,4,"0",STR_PAD_LEFT),"price"=>"10.00","attribute_set"=>"Default","store"=>"admin","description"=>"ingested with Datapump API - item $i");

         // Now ingest item into magento
         $dp->ingest($testitem);
        }


        // End import Session
        $dp->endImportSession();    
    }
}