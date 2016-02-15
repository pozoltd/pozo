<?php

namespace Pz\DAOs;

use Pz\Common\Utils;
use ReflectionObject;

abstract class DoctrineDAO implements DAOInterface
{
    private $db;

    abstract function getFieldMap();
    abstract function getORMClass();
    abstract function getBaseQuery();

    public function __construct($db) {
        $this->db = $db;
        foreach ($this->getFieldMap() as $key => $value) {
            $this->{$key} = null;
        }
    }

    /**
     * for content only
     * @return mixed|null
     */
    public function getModel() {
        if (isset($this->modelId)) {
            return \Pz\DAOs\Model::findById($this->db, $this->modelId);
        }
        return null;
    }

    public function save() {
        $myClass = $this->getORMClass();
        if ($this->id) {
            $repo = $this->db->getRepository($myClass);
            $m = $repo->find($this->id);
        } else {
            $m = new $myClass();
        }

        $reflectionObj = new ReflectionObject($m);
        foreach ($this->getFieldMap() as $idx => $itm) {
            if (property_exists($this, $idx)) {
                if ($itm == 'id') {
                    continue;
                }
                $reflectionMethod = $reflectionObj->getMethod('set' . ucfirst($itm));

                $value = $this->{$idx};
                if (strpos($itm, 'date') !== false && $this->{$idx}) {
                    $date = new \DateTime();
                    $date->setTimestamp(strtotime($this->{$idx}));
                    $value = $date;
                }
                $reflectionMethod->invoke($m, $value);
            }
        }

        $this->db->persist($m);
        $this->db->flush();
        return $m->getId();
    }

    public static function findByTitle($db, $title) {
        $daos = static::data($db, array(
            'whereSql' => 'entity.title = :v1',
            'params' => array(
                'v1' => $title,
            )
        ));
        return array_pop($daos);
    }

    public static function findById($db, $id) {
        $daos = static::data($db, array(
            'whereSql' => 'entity.id = :v1',
            'params' => array(
                'v1' => $id,
            )
        ));
        return array_pop($daos);
    }

    public static function data($db, $options=array())
    {
        $myClass = get_called_class();
        $m = new $myClass($db);

        $select = isset($options['select']) ? $options['select'] : 'entity';
        $whereSql = isset($options['whereSql']) ? $options['whereSql'] : null;
        $params = isset($options['params']) ? $options['params'] : array();
        $page = isset($options['page']) ? $options['page'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : null;
        $sort = isset($options['sort']) ? $options['sort'] : 'entity.rank';
        $order = isset($options['order']) ? $options['order'] : 'ASC';
        $groupBy = isset($options['groupBy']) ? $options['groupBy'] : null;
        $jt = isset($options['jt']) ? $options['jt'] : null;

        $whereSql = static::convert($m, $whereSql);
//        foreach ($params as $idx => $itm) {
//            foreach ($model['columnsJson'] as $itm2) {
//                if ($idx == $itm2['field']) {
//                    unset($params[$idx]);
//                    $params[$itm2['mapping']] = $itm;
//                }
//            }
//        }

        $sort = static::convert($m, $sort);


        $qb = $db->createQueryBuilder()->from($m->getORMClass(), $select);
        $qb->select($select);

        if ($m->getBaseQuery()) {
            $qb->where($m->getBaseQuery());
        }

        if (!empty($whereSql)) {
            $qb->andWhere($whereSql);
        }

        if (count($params) > 0) {
            $qb->setParameters($params);
        }

        if ($page && $limit) {
            $qb->setFirstResult(($page - 1) * $limit);
            $qb->setMaxResults($limit);
        }

        if ($sort && $order) {
            $qb->orderBy($sort, $order);
        }

        if ($groupBy) {
            $qb->groupBy($groupBy);
        }

        if ($jt && gettype($jt) == 'array') {
            foreach ($jt as $itm) {
                $funcname = 'leftJoin';
                if (isset($itm['type'])) {
                    $funcname = $itm['type'];
                }
                if (isset($itm['on'])) {
                    $qb->$funcname($itm['join'], $itm['alias'], \Doctrine\ORM\Query\Expr\Join::WITH, $itm['on']);
                } else {
                    $qb->$funcname($itm['join'], $itm['alias']);
                }
            }
        }

        $orms = $qb->getQuery()->getResult();

        $daos = array();
        foreach ($orms as $orm) {
            $dao = new $myClass($db);
            foreach ($m->getFieldMap() as $key => $value) {
                $funcName = "get" . ucfirst($value);
                $dao->{$key} = $orm->{$funcName}();
            }
            $daos[] = $dao;
        }
        return $daos;

    }

    public static function convert($m, $sql) {
        $fieldMap = $m->getFieldMap();
        uasort($fieldMap, function($a, $b) {
            return strlen($b) - strlen($a);
        });
        foreach ($fieldMap as $idx => $itm) {
            $sql = str_replace($idx, $itm, $sql);
        }
        return $sql;
    }
}