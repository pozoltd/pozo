<?php

/**
 * 2016-04-11 22:17:37
 */
namespace Pz\DAOs\Generated;

class Order extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title',
			'uniqueId' => 'about',
			'message' => 'extra11',
			'startdate' => 'startdate',
			'shippingPrice' => 'extra1',
			'totalPrice' => 'price',
			'firstname' => 'firstname',
			'lastname' => 'lastname',
			'email' => 'email',
			'phone' => 'phone',
			'address1' => 'address',
			'address2' => 'extra6',
			'city' => 'extra2',
			'postcode' => 'extra4',
			'state' => 'extra10',
			'country' => 'extra3',
			'paymentStatus' => 'extra5',
			'paymentRequest' => 'extra7',
			'paymentResponse' => 'extra8',
			'paymentToken' => 'extra13',
			'emailRequest' => 'extra12',
			'emailResponse' => 'extra9',
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 10';
    }


}