<?php

/**
 * 2016-02-26 20:50:53
 */
namespace Pz\DAOs;

class Page extends \Pz\DAOs\Generated\Page {

    public function objTemplate() {
        return Template::findById($this->db, $this->template);
    }

}