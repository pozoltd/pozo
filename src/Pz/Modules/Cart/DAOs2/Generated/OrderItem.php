<?php

/**
 * 2016-07-08 21:55:42
 */
namespace Pz\Modules\Cart\DAOs\Generated;

class OrderItem extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'quantity' => 'extra3', 
			'price' => 'price', 
			'weight' => 'value', 
			'subtotal' => 'extra1', 
			'product' => 'extra2', 
			'orderId' => 'extra4', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 11';
    }

    
}