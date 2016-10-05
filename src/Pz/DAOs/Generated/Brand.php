<?php

/**
 * 2016-07-31 21:00:36
 */
namespace Pz\DAOs\Generated;

class Brand extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 15';
    }

    
}