<?php

namespace Pz\DAOs;

use Doctrine\ORM\Mapping as ORM;

class Model extends \Pz\DAOs\DAO {
    static function getFieldMap() {
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

    function getClass() {
        return 'Pz\Entities\Model';
    }


}