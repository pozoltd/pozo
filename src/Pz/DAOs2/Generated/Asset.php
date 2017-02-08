<?php

/**
 * 2016-04-11 22:17:37
 */
namespace Pz\DAOs\Generated;

class Asset extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'description' => 'description', 
			'isFolder' => 'extra1', 
			'fileName' => 'extra2', 
			'fileType' => 'extra4', 
			'fileSize' => 'extra5', 
			'fileLocation' => 'extra6', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 3';
    }

    
}