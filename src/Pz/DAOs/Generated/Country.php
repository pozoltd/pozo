<?php

/**
 * 2016-07-07 22:54:57
 */
namespace Pz\DAOs\Generated;

class Country extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 18';
    }

    
}