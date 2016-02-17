<?php

namespace Pz\DAOs;

use Doctrine\ORM\Mapping as ORM;
use Pz\Common\Utils;

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

    public function save() {
        $generated = HOME_DIR . '/src/' . DEFAULT_NAMESPACE . '/DAOs/Generated/' . $this->className . '.php';
        $customised = HOME_DIR . '/src/' . DEFAULT_NAMESPACE . '/DAOs/' . $this->className . '.php';
        if (file_exists($generated)) {
            unlink($generated);
        }

        $columnsJson = json_decode($this->columnsJson);
        $mappings = array_map(function($value) {
            return "'{$value->field}' => '{$value->column}', ";
        }, $columnsJson);

        $extras = array_map(function($value) {
            if ($value->widget == 'checkbox') {
                $txt = "\n\tpublic function get" . ucfirst($value->field) . "() {\n";
                $txt .= "\t\t \$this->{$value->field} == 1 ? true : false;";
                $txt .= "\n\t}\n";
                return $txt;
            }
        }, $columnsJson);
        $extras = array_filter($extras);

        $str = file_get_contents(__DIR__ . '/templates/generated.txt');
        $str = str_replace('{TIMESTAMP}', date('Y-m-d H:i:s'), $str);
        $str = str_replace('{NAMESPACE}', DEFAULT_NAMESPACE, $str);
        $str = str_replace('{CLASSNAME}', $this->className, $str);
        $str = str_replace('{MODELID}', $this->id, $str);
        $str = str_replace('{MAPPING}', join("\n\t\t\t", $mappings), $str);
        $str = str_replace('{EXTRAS}', count($extras) == 0 ? '' : join("\n\t\t\t", $extras), $str);
        file_put_contents($generated, $str);

        if (!file_exists($customised)) {
            $str = file_get_contents(__DIR__ . '/templates/customised.txt');
            $str = str_replace('{TIMESTAMP}', date('Y-m-d H:i:s'), $str);
            $str = str_replace('{NAMESPACE}', DEFAULT_NAMESPACE, $str);
            $str = str_replace('{CLASSNAME}', $this->className, $str);
            file_put_contents($customised, $str);
        }

        parent::save();
    }

}