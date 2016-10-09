<?php

/**
 * 2016-03-04 21:39:25
 */
namespace Pz\Modules\Cart\DAOs;

class Product extends \Pz\Modules\Cart\DAOs\Generated\Product {

    public function save() {

        $this->title = ($this->subtitle1 ? $this->subtitle1 . ' ' : '') . ($this->subtitle2 ? $this->subtitle2 . ' ' : '') . ($this->subtitle3 ? $this->subtitle3 . ' ' : '');
        parent::save();
    }

    public function objCategory() {
        return \Pz\Modules\Cart\DAOs\ProductCategory::findById($this->db, $this->category);
    }

}