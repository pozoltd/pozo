<?php

/**
 * 2016-07-07 23:01:10
 */
namespace Pz\DAOs\Generated;

class Shipping extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'description' => 'description', 
			'upto' => 'extra1', 
			'firstPrice' => 'price', 
			'additionalPrice' => 'extra2', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 19';
    }

    
}