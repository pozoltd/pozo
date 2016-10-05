<?php

/**
 * 2016-04-13 21:15:55
 */
namespace Pz\DAOs\Generated;

class Template extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'filename' => 'name', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 17';
    }

    
}