<?php

/**
 * 2016-04-11 22:17:37
 */
namespace Pz\DAOs\Generated;

class ImageSize extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'width' => 'extra1', 
			'description' => 'description', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 4';
    }

    
}