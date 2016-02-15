<?php

namespace Pz\DAOs;

use Doctrine\ORM\Mapping as ORM;
use Pz\Common\Utils;

abstract class Content extends \Pz\DAOs\DoctrineDAO {

    public function __construct($db) {
        parent::__construct($db);
        $this->slug = '';
        $this->modelId = str_replace('entity.modelId = ', '', $this->getBaseQuery());
        $this->active = 1;
        $this->rank = 0;
        $this->parentId = 0;
        $this->added = new \DateTime('now');
        $this->modified = new \DateTime('now');
    }

    public function save() {
        $this->modified = new \DateTime('now');
        $this->slug = Utils::slugify($this->title);
        return parent::save();
    }
}