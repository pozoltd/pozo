<?php

namespace Pz\Database;


interface DAOInterface
{
    public static function data($db, $options);
    public function save();
    public function getFieldMap();
    public function getORMClass();
    public function getBaseQuery();
}