<?php

namespace Pz\ORMs;


abstract class DAO implements DAOInterface
{
    public static function data($db, $options)
    {
        $select = isset($options['select']) ? $options['select'] : 'entity';
        $whereDql = isset($options['whereDql']) ? $options['whereDql'] : null;
        $params = isset($options['params']) ? $options['params'] : array();
        $page = isset($options['page']) ? $options['page'] : null;
        $limit = isset($options['limit']) ? $options['limit'] : null;
        $sort = isset($options['sort']) ? $options['sort'] : null;
        $order = isset($options['order']) ? $options['order'] : null;
        $groupBy = isset($options['groupBy']) ? $options['groupBy'] : null;
        $jt = isset($options['jt']) ? $options['jt'] : null;

        $qb = $db->createQueryBuilder()->from($db->getClassName(), 'entity');
        $qb->select($select);

        if (!empty($whereDql)) {
            $qb->where($whereDql);
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

        return $qb->getQuery()->getResult();
    }

    abstract static function getFieldMap();

    abstract function getClass();

}