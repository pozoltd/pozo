<?php

namespace Pz\ORM;


interface ORMInterface
{
    public static function data($db, $options);
    public function getFieldMap();
    public function getClass();
}


abstract class ORM implements ORMInterface
{
    public static function data($db, $options) {

    }

    abstract function getFieldMap();
    abstract function getClass();

}