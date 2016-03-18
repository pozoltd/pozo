<?php
namespace Pz\Controllers;

use Imagick;
use Pz\Common\Utils;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Cart extends  AssetView
{

    public function connect(Application $app)
    {
        $controllers = parent::connect($app);
        $controllers->match('/', array($this, 'cart'));
        $controllers->match('/add/', array($this, 'add'));
        return $controllers;
    }

    public function cart(Application $app, Request $request)
    {
        $order = $app['session']->get('order');

        if (!$order) {
            $order = new \Site\DAOs\Order($app['em']);
            $order->startdate = date('Y-m-d H:i:s');
            $order->status = 0;
            $order->_items = array();
        }

        $page = \Site\DAOs\Page::findByField($app['em'], 'url', '/cart/');
        return $app['twig']->render($page->template, array(
            'pageBuilder' => $page,
            'order' => $order,
        ));
    }

    public function add(Application $app, Request $request)
    {
        $order = $app['session']->get('order');
        if (!$order) {
            $order = new \Site\DAOs\Order(null);
            $order->startdate = date('Y-m-d H:i:s');
            $order->status = 0;
            $order->_items = array();
        }

        $product = \Site\DAOs\Product::findById($app['em'], $request->get('product'));
        $quantity = $request->get('quantity');
        if ($product) {
            $orderItem = new \Site\DAOs\OrderItem($app['em']);
            $quantity = $quantity < 1 ? 1 : $quantity;
            $orderItem->title = $product->title;
            $orderItem->prodcut = $product->id;
            $orderItem->quantity = $quantity;
            $orderItem->price = $product->price;
            $orderItem->subtotal = $product->price * $quantity;
            $order->_items[] = $orderItem;
        }

        $order = $app['session']->set('order', ($order));
        return $app->redirect('/cart/');
    }


}