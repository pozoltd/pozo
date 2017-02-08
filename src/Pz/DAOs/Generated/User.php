<?php

/**
 * 2016-04-11 22:17:37
 */
namespace Pz\DAOs\Generated;

class User extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'title' => 'username', 
			'password' => 'password', 
			'password_' => 'extra1', 
			'name' => 'name', 
			'email' => 'email', 
			'image' => 'image', 
			'folder' => 'extra3', 
			'description' => 'description', 
			'resetToken' => 'extra2', 
			'resetDate' => 'date1', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 1';
    }

    
}