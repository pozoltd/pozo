<?php

/**
 * 2016-07-07 22:45:40
 */
namespace Pz\DAOs\Generated;

class FormDescriptor extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'title', 
			'code' => 'extra4', 
			'from' => 'extra3', 
			'recipients' => 'extra1', 
			'fields' => 'content', 
			'thankyouMessage' => 'shortdescription', 
			'antiSpam' => 'extra2', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 12';
    }

    
	public function getAntiSpam() {
		return $this->antiSpam == 1 ? true : false;
	}

}