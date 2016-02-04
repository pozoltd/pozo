<?php

namespace Pz\DAOs;

use Doctrine\ORM\Mapping as ORM;

class Model extends \Pz\DAOs\DoctrineDAO {

    public function getFieldMap() {
        return array(
            'id' => 'id',
            'rank' => 'rank',
            'label' => 'label',
            'className' => 'className',
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

}