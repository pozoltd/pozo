<?php

namespace Pz\Database;

use Pz\Common\Utils;
use ReflectionObject;
use Serializable;

abstract class DoctrineDAO implements DAOInterface
{
    protected $db;

    abstract function getFieldMap();

    abstract function getORMClass();

    abstract function getBaseQuery();

    public function __construct($db)
    {
        $this->db = $db;
        foreach ($this->getFieldMap() as $key => $value) {
            $this->{$key} = null;
        }
    }

    public function __sleep()
    {
        return array_diff(array_keys(get_object_vars($this)), array('db'));
    }

    public function __wakeup()
    {
        $app = require __DIR__ . '/../../../bootstrap.php';
        $this->db = $app['em'];
    }

    public function delete()
    {
        $myClass = $this->getORMClass();
        if ($this->id) {
            $repo = $this->db->getRepository($myClass);
            $m = $repo->find($this->id);
            if ($m) {
                $this->db->remove($m);
                $this->db->flush();
                return true;
            }
        }
        return false;
    }

    public function save()
    {
        $myClass = $this->getORMClass();
        if (isset($this->id) && $this->id) {
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
                if (strpos($itm, 'date') !== false && $this->{$idx} && gettype($this->{$idx}) == 'string') {
                    $date = new \DateTime();
                    $date->setTimestamp(strtotime($this->{$idx}));
                    $value = $date;
                }
                $reflectionMethod->invoke($m, $value);
            }
        }

        $this->db->persist($m);
        $this->db->flush();
        $this->id = $m->getId();
    }

    public static function findBySlug($db, $slug)
    {
        return static::findByField($db, 'slug', $slug);
    }

    public static function findByTitle($db, $title)
    {
        return static::findByField($db, 'title', $title);
    }

    public static function findById($db, $id)
    {
        return static::findByField($db, 'id', $id);
    }

    public static function findByField($db, $field, $value)
    {
        return static::data($db, array(
            'whereSql' => 'entity.' . $field . ' = :v1',
            'params' => array(
                'v1' => $value,
            ),
            'oneOrNull' => true,
        ));
    }

    public static function active($db, $options = array())
    {
        $whereSql = isset($options['whereSql']) ? $options['whereSql'] : null;
        if ($whereSql) {
            $whereSql .= ' AND (entity.active = 1)';
        } else {
            $whereSql = 'entity.active = 1';
        }
        $options['whereSql'] = $whereSql;
        return static::data($db, $options);
    }

    public static function data($db, $options = array())
    {
        $myClass = get_called_class();
        $m = new $myClass($db);

        $count = isset($options['count']) ? $options['count'] : 0;
        $select = isset($options['select']) ? $options['select'] : 'entity';
        $whereSql = isset($options['whereSql']) ? $options['whereSql'] : null;
        $params = isset($options['params']) ? $options['params'] : array();
        $page = isset($options['page']) ? $options['page'] : 1;
        $limit = isset($options['limit']) ? $options['limit'] : null;
        $sort = isset($options['sort']) ? $options['sort'] : 'entity.rank';
        $order = isset($options['order']) ? $options['order'] : 'ASC';
        $groupBy = isset($options['groupBy']) ? $options['groupBy'] : null;
        $jt = isset($options['jt']) ? $options['jt'] : null;
        $dao = isset($options['dao']) ? $options['dao'] : true;
        $oneOrNull = isset($options['oneOrNull']) ? $options['oneOrNull'] : false;

        if ($count) {
            $select = 'COUNT(entity.id) AS total';
            $dao = 0;
        }

        $whereSql = static::convert($m, $whereSql);
        $params = static::convertParams($m, $params);

        if (isset($options['debug'])) {
            var_dump($whereSql, $params);exit;
        }

        $sort = static::convert($m, $sort);


        $qb = $db->createQueryBuilder()->from($m->getORMClass(), 'entity');
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

        if ($dao) {
            $daos = array();
            foreach ($orms as $orm) {
                $dao = new $myClass($db);
                foreach ($m->getFieldMap() as $key => $value) {
                    $funcName = "get" . ucfirst($value);
                    $dao->{$key} = $orm->{$funcName}();
                }
                $daos[] = $dao;
            }
            if ($oneOrNull) {
                return count($daos) > 0 ? $daos[0] : null;
            }
            return $daos;
        } else {
            return $orms;
        }
    }

    public static function convert($m, $sql)
    {
        $fieldMap = $m->getFieldMap();
        uasort($fieldMap, function ($a, $b) {
            return strlen($b) - strlen($a);
        });
        foreach ($fieldMap as $idx => $itm) {
            $sql = str_replace($idx, $itm, $sql);
        }
        return $sql;
    }

    public static function convertParams($m, $params)
    {
        $fieldMap = $m->getFieldMap();
        uasort($fieldMap, function ($a, $b) {
            return strlen($b) - strlen($a);
        });
        $result = array();
        foreach ($params as $idx => $itm) {
            if (isset($fieldMap[$idx])) {
                $idx = $fieldMap[$idx];
            }
            $result[$idx] = $itm;
        }
        return $result;
    }
}