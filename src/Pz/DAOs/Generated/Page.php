<?php

/**
 * 2016-04-13 21:28:09
 */
namespace Pz\DAOs\Generated;

class Page extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'type' => 'extra5', 
			'category' => 'category', 
			'url' => 'url', 
			'content' => 'content', 
			'categoryRank' => 'extra2', 
			'categoryParent' => 'extra3', 
			'pageTitle' => 'extra4', 
			'description' => 'description', 
			'redirectTo' => 'extra6', 
			'template' => 'authorbio', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 7';
    }

    
}