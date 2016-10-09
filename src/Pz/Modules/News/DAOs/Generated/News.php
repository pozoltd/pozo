<?php

/**
 * 2016-07-07 22:39:48
 */
namespace Pz\Modules\News\DAOs\Generated;

class News extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'content' => 'content', 
			'pageTitle' => 'extra1', 
			'description' => 'description', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 8';
    }

    
}