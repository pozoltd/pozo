<?php

/**
 * 2016-03-18 22:35:01
 */
namespace Pz\Modules\Cart\DAOs;

use Pz\Common\Utils;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Order extends \Pz\Modules\Cart\DAOs\Generated\Order {

    public function getCartOrderItems() {
        if (isset($this->cartOrderItems) && gettype($this->cartOrderItems) == 'array') {
            return $this->cartOrderItems;
        }
        return OrderItem::active($this->db, array(
            'whereSql' => 'entity.orderId = :v1',
            'params' => array(
                'v1' => $this->id,
            )
        ));
    }

    public function getCartTotalPrice() {
        $total = 0;
        foreach ($this->getCartOrderItems() as $itm) {
            $total += $itm->subtotal;
        }
        $this->totalPrice = $total + $this->getCartShippingPrice();
        return $this->totalPrice;
    }

    public function getCartTotalWeight() {
        $total = 0;
        foreach ($this->getCartOrderItems() as $itm) {
            $total += $itm->weight * $itm->quantity;
        }
        return $total;
    }

    public function getCartShippingPrice() {
        $this->__wakeup();
        $totalWeight = $this->getCartTotalWeight();
        if ($totalWeight == 0) {
            return 0;
        }
        $shipping = Shipping::active($this->db, array(
            'whereSql' => 'entity.title LIKE :v1',
            'params' => array('v1' => '%"' . $this->getCountry() . '"%'),
            'oneOrNull' => true,
        ));
        if (($totalWeight / 1000) <= $shipping->upto) {
            return $shipping->firstPrice;
        } else {
            return $shipping->firstPrice + (ceil(($totalWeight / 1000) - $shipping->upto) * $shipping->additionalPrice);
        }
    }

    public function getOrderitems() {
        return OrderItem::data($this->db, array(
            'whereSql' => 'entity.orderId = :v1',
            'params' => array(
                'v1' => $this->id,
            )
        ));
    }

    public function getCountry() {
        $this->__wakeup();
        if ($this->country) {
            return $this->country;
        }
        $shipping = Shipping::active($this->db, array(
            'oneOrNull' => true,
        ));
        $countries = json_decode($shipping->title);
        if (count($countries) == 0) {
            throw new AccessDeniedHttpException('No shipping methods found');
        }
        $this->country = $countries[0];
        return $this->country;
    }

    public function getCountries() {
        $this->__wakeup();
        $countries = array();
        $shippings = Shipping::active($this->db);
        foreach ($shippings as $itm) {
            $countries = array_merge($countries, json_decode($itm->title));
        }
        $countries = array_combine(array_values($countries), array_values($countries));
        return $countries;
    }
}