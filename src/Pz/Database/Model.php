<?php

namespace Pz\Database;

use Doctrine\ORM\Mapping as ORM;

class Model extends DoctrineDAO {

    public function getFieldMap() {
        return array(
            'id' => 'id',
            'rank' => 'rank',
            'label' => 'label',
            'className' => 'className',
            'namespace' => 'namespace',
            'modelType' => 'modelType',
            'dataType' => 'dataType',
            'listType' => 'listType',
            'numberPerPage' => 'numberPerPage',
            'defaultSortBy' => 'defaultSortBy',
            'defaultOrder' => 'defaultOrder',
            'columnsJson' => 'columnsJson',
        );
    }

    public function getORMClass() {
        return 'Pz\Entities\Model';
    }

    public function getBaseQuery() {
        return null;
    }

    public function getFullClass() {
        return '\\' . $this->namespace . '\\' . $this->className;
    }

}