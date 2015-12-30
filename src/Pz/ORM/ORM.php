<?php

namespace Pz\ORM;


abstract class ORM extends \Pz\Entities\Content implements ORMInterface
{
    public function data($db, $options) {

    }

    abstract function getFieldMap();
}