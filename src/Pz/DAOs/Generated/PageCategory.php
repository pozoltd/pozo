<?php

/**
 * 2016-04-11 22:17:37
 */
namespace Pz\DAOs\Generated;

class PageCategory extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'code' => 'extra1', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 5';
    }

    
}