<?php

/**
 * 2016-07-31 21:22:27
 */
namespace Pz\DAOs\Generated;

class ProductCategory extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'brands' => 'extra1', 
			'image' => 'image', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 14';
    }

    
}