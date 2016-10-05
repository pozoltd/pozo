<?php

/**
 * 2016-07-31 19:33:45
 */
namespace Pz\DAOs\Generated;

class Product extends \Pz\Database\Content {

    function getFieldMap() {
        global $CMS_METAS;
        return array_merge(array(
            'subtitle1' => 'shortdescription', 
			'price' => 'price', 
			'subtitle2' => 'extra2', 
			'subtitle3' => 'extra4', 
			'category' => 'category', 
			'brand' => 'extra3', 
			'weight' => 'extra6', 
			'outOfStock' => 'isactive', 
			'image' => 'image', 
			'gallery' => 'gallery', 
			'featured' => 'features', 
			'featuredImage' => 'extra5', 
			'description' => 'description', 
			'directions' => 'extra1', 
			'ingredients' => 'content', 
			'title' => 'title', 
        ), array_combine($CMS_METAS, $CMS_METAS));
    }

    function getBaseQuery() {
        return 'entity.modelId = 9';
    }

    
	public function getOutOfStock() {
		return $this->outOfStock == 1 ? true : false;
	}

			
	public function getFeatured() {
		return $this->featured == 1 ? true : false;
	}

}