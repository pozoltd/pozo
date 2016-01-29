<?php

namespace Pz\ORMs;


interface DAOInterface
{
    public static function data($db, $options);

    public static function getFieldMap();

    public function getClass();
}