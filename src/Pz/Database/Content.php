<?php

namespace Pz\Database;

use Pz\Common\Utils;

abstract class Content extends DoctrineDAO {

    public function __construct($db) {
        parent::__construct($db);
        $this->slug = '';
        $this->modelId = str_replace('entity.modelId = ', '', $this->getBaseQuery());
        $this->rank = 0;
        $this->parentId = 0;
        $this->added = new \DateTime('now');
        $this->modified = new \DateTime('now');
        $this->active = 1;
    }

    public function save() {
        $this->modified = new \DateTime('now');
        $this->slug = Utils::slugify($this->title);
        return parent::save();
    }

    public function getORMClass() {
        return 'Pz\Entities\Content';
    }
}