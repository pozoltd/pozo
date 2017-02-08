<?php

/**
 * 2016-04-11 22:18:01
 */
namespace Pz\DAOs\Generated;

class FormSubmission extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'uniqueId' => 'about', 
			'date' => 'date', 
			'from' => 'extra4', 
			'recipients' => 'extra5', 
			'content' => 'content', 
			'emailStatus' => 'extra1', 
			'emailRequest' => 'extra2', 
			'emailResponse' => 'extra3', 
			'formDescriptorId' => 'extra6', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 13';
    }

    
}