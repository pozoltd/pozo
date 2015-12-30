<?php

namespace Pz\ORM;


interface ORMInterface
{
    public function data($db, $options);
    public function getFieldMap();
}