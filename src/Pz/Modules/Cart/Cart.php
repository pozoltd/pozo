<?php
namespace Pz\Modules\Cart;

use Imagick;
use Omnipay\Common\CreditCard;
use Omnipay\Common\GatewayFactory;
use Pz\Common\Utils;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Cart implements ControllerProviderInterface
{
    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/', array($this, 'cart'))->bind('cart');
        $controllers->match('/confirm/', array($this, 'confirm'))->bind('cart-confirm');
        $controllers->match('/paypal/', array($this, 'paypal'))->bind('cart-paypal');
        $controllers->match('/paypal/complete/', array($this, 'paypalComplete'))->bind('cart-paypal-complete');
        $controllers->match('/banking/', array($this, 'banking'))->bind('cart-banking');
        $controllers->match('/add/', array($this, 'add'))->bind('cart-add');
        $controllers->match('/clear/', array($this, 'clear'))->bind('cart-clear');
        $controllers->match('/update/', array($this, 'update'))->bind('cart-update');
        $controllers->match('/update/country/', array($this, 'updateCountry'))->bind('cart-update-country');
        $controllers->match('/remove/', array($this, 'remove'))->bind('cart-remove');
        return $controllers;
    }

    public function cart(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        if (!($order instanceof $app['orderClass'])) {
            return $order;
        }

        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Cart(), $order);
        $form = $formBuilder->getForm();

        $page = $app['pageClass']::findByField($app['em'], 'url', '/cart/');
        $template = 'cart.twig';
        return $app['twig']->render($template, array(
            'form' => $form->createView(),
            'pageBuilder' => $page,
            'order' => $order,
        ));
    }

    public function confirm(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        if (!($order instanceof $app['orderClass'])) {
            return $order;
        }

        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Cart(), $order);
        $form = $formBuilder->getForm();

        $pageClass = $app['pageClass'];
        $page = $pageClass::findByField($app['em'], 'url', '/cart/');
        $template = 'cart.twig';

        $form->handleRequest($request);
        if ($form->isValid()) {
            $app['session']->set('cart', $order);
            $template = 'cart-confirm.twig';
        }

        return $app['twig']->render($template, array(
            'form' => $form->createView(),
            'pageBuilder' => $page,
            'order' => $order,
        ));
    }

    public function paypal(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        if (!($order instanceof $app['orderClass'])) {
            return $order;
        }

        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Cart(), $order);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return $app->redirect($app->url('cart-confirm'));
        }

        $order->save();
        foreach ($order->cartOrderItems as $itm) {
            $itm->orderId = $order->id;
            $itm->save();
        }

        $action = $request->get('action');
        if ($action == 1) {
            $gateway = $this->getPaypalGateway($app);
            $params = $this->getPaypalParams($order);
            $response = $gateway->purchase($params)->send();

            $order->title = "#{$order->uniqueId} {$order->firstname} {$order->lastname} (\$" . number_format($order->totalPrice, 2, '.', ',') . ") - Pending";
            $order->paymentStatus = $action;
            $order->paymentRequest = json_encode($response->getData());
            $order->paymentToken = $response->getTransactionReference();
            $order->save();

            if ($response->isSuccessful()) {
                print_r($response);
                exit;
            } elseif ($response->isRedirect()) {
                $response->redirect();
            }

            return $app->redirect($app->url('cart'));

        } else if ($action == 4) {
            $order->title = "#{$order->uniqueId} {$order->firstname} {$order->lastname} (\$" . number_format($order->totalPrice, 2, '.', ',') . ") - Offline Payment";
            $order->paymentStatus = $action;
            $order->paymentRequest = '';
            $order->paymentToken = 'BT-' . strtoupper(substr(md5(uniqid() . time()), 0, 24));

            $messageBody = $this->app['twig']->render('cart-invoice.twig', array(
                'order' => $order,
            ));
            $message = \Swift_Message::newInstance()
                ->setSubject($app['get']->system('website-title') . ' ORDER #' . $order->uniqueId . ($order->paymentStatus == 3 ? ' (Declined)' : ''))
                ->setFrom(array($app['get']->system('email-from')))
                ->setTo(array($order->email))
                ->setBcc(array(EMAIL_BCC, $app['get']->system('email-owner')))
                ->setBody(
                    $messageBody,'text/html'
                );

            $order->emailResponse = $this->app['mailer']->send($message);
            $order->emailRequest = $messageBody;
            $order->save();

            return $app->redirect($app->url('cart-banking', array(
                'token' => $order->paymentToken,
            )));
        }


    }

    public function paypalComplete(Application $app, Request $request) {
        $pageClass = $app['pageClass'];
        $page = $pageClass::findByField($app['em'], 'url', '/cart/');
        $template = 'cart.twig';

        $token = $request->get('token');
        $orderClass = $app['orderClass'];
        $order = $orderClass::findByField($app['em'], 'paymentToken', $token);
        if (!$order) {
            $app->abort(404);

        } else if ($order->paymentStatus == 1) {

            $params = $this->getPaypalParams($order);
            $gateway = $this->getPaypalGateway($app);
            $response = $gateway->completePurchase($params)->send();
            $paypalResponse = $response->getData();

            $order->paymentResponse = json_encode($paypalResponse);

            if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
                $template = 'cart-success.twig';
                $order->title = "#{$order->uniqueId} {$order->firstname} {$order->lastname} (\$" . number_format($order->totalPrice, 2, '.', ',') . ") - Approved";
                $order->paymentStatus = 2;
                $app['session']->set('cart', null);
            } else {
                $template = 'cart-failed.twig';
                $order->title = "#{$order->uniqueId} {$order->firstname} {$order->lastname} (\$" . number_format($order->totalPrice, 2, '.', ',') . ") - Declined";
                $order->paymentStatus = 3;
            }

            $messageBody = $this->app['twig']->render('cart-invoice.twig', array(
                'order' => $order,
            ));
            $message = \Swift_Message::newInstance()
                ->setSubject($app['get']->system('website-title') . ' ORDER #' . $order->uniqueId . ($order->paymentStatus == 3 ? ' (Declined)' : ''))
                ->setFrom(array($app['get']->system('email-from')))
                ->setTo(array($order->email))
                ->setBcc(array(EMAIL_BCC, $app['get']->system('email-owner')))
                ->setBody(
                    $messageBody,'text/html'
                );
            $order->emailResponse = $this->app['mailer']->send($message);
            $order->emailRequest = $messageBody;
            $order->save();

        } else if ($order->paymentStatus == 2) {
            $template = 'cart-success.twig';
        } else if ($order->paymentStatus == 3) {
            $template = 'cart-failed.twig';
        }

        return $app['twig']->render($template, array(
            'pageBuilder' => $page,
            'order' => $order,
        ));
    }

    public function banking(Application $app, Request $request) {
        $pageClass = $app['pageClass'];
        $page = $pageClass::findByField($app['em'], 'url', '/cart/');
        $template = 'cart-banking.twig';

        $token = $request->get('token');
        $orderClass = $app['orderClass'];
        $order = $orderClass::findByField($app['em'], 'paymentToken', $token);
        if (!$order) {
            $app->abort(404);
        }

        $app['session']->set('cart', null);
        return $app['twig']->render($template, array(
            'pageBuilder' => $page,
            'order' => $order,
        ));
    }


    public function add(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        $productClass = $app['productClass'];
        $product = $productClass::findById($app['em'], $request->get('product'));
        if ($product) {
            $quantity = $request->get('quantity');
            $orderItemClass = $app['orderItemClass'];
            $orderItem = new $orderItemClass($app['em']);
            $quantity = $quantity < 1 ? 1 : $quantity;
            $orderItem->title = $product->title;
            $orderItem->prodcut = $product->id;
            $orderItem->quantity = $quantity;
            $orderItem->price = $product->price;
            $orderItem->weight = $product->weight;
            $orderItem->subtotal = $product->price * $quantity;
            $order->cartOrderItems[] = $orderItem;
        }

        $app['session']->set('cart', $order);
        return $app->redirect('/cart/');
    }

    public function clear(Application $app, Request $request)
    {
        $app['session']->set('cart', null);
        return $app->redirect('/cart/');
    }

    public function update(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        if (isset($order->cartOrderItems[$request->get('idx')])) {
            $order->cartOrderItems[$request->get('idx')]->quantity = $request->get('quantity') && is_numeric($request->get('quantity')) && $request->get('quantity') > 0 ? $request->get('quantity') : 1;
            $order->cartOrderItems[$request->get('idx')]->subtotal = $order->cartOrderItems[$request->get('idx')]->quantity * $order->cartOrderItems[$request->get('idx')]->price;
        }

        $app['session']->set('cart', $order);
        return new Response('OK');
    }

    public function updateCountry(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        $order->country = $request->get('country');
        $app['session']->set('cart', $order);
        return new Response('OK');
    }

    public function remove(Application $app, Request $request)
    {
        $order = $this->getOrderFromSession($app);
        if (isset($order->cartOrderItems[$request->get('idx')])) {
            array_splice($order->cartOrderItems, $request->get('idx'), 1);
        }

        $app['session']->set('cart', $order);
        return new Response('OK');
    }


    private function getOrderFromSession(Application $app)
    {
        $order = $app['session']->get('cart');
        if (!$order) {
            $orderClass = $app['orderClass'];
            $order = new $orderClass(null);
            $order->uniqueId = uniqid();
            $order->startdate = date('Y-m-d H:i:s');
            $order->paymentStatus = 0;
            $order->cartOrderItems = array();
            return $order;
        }

        if (isset($order->id) && $order->id) {
            unset($order->id);
            $order->uniqueId = uniqid();
        }

        if (count($order->cartOrderItems) == 0) {
            $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Cart(), $order);
            $form = $formBuilder->getForm();

            $pageClass = $app['orderClass'];
            $page = $pageClass::findByField($app['em'], 'url', '/cart/');
            $template = 'cart.twig';

            return $app['twig']->render($template, array(
                'form' => $form->createView(),
                'pageBuilder' => $page,
                'order' => $order,
            ));
        }
        if ($order->paymentStatus == 2) {
            $app['session']->set('cart', null);
            return $app->redirect($app->url('cart'));
        } else if ($order->paymentStatus == 3) {
            $order->id = null;
            $app['session']->set('cart', $order);
        }
        return $order;
    }

    private function getPaypalGateway($app) {
        $factory = new GatewayFactory();
        $gateway = $factory->create('PayPal_Express');
        $gateway->setUsername($app['get']->system('paypal-username'));
        $gateway->setPassword($app['get']->system('paypal-password'));
        $gateway->setSignature($app['get']->system('paypal-signature'));
        $gateway->setTestMode($app['get']->system('paypal-testmode') == 'true' ? true : false);
//        $gateway->setUsername('ns.gresource_api1.gmail.com');
//        $gateway->setPassword('T7ZDTGU6KN3ZVHQL');
//        $gateway->setSignature('AlHocZw.D-4wIMlpxjF1YGncCpfIAicPkwVrE4CMz47JMRS0lm9rg57f');
//        $gateway->setTestMode(false);
        return $gateway;
    }


    private function getPaypalParams($order) {
        $cardInput = array(
            'firstName' => $order->firstname,
            'lastName' => $order->lastname,
            'billingAddress1' => $order->address1,
            'billingAddress2' => $order->address2,
            'billingPhone' => $order->phone,
            'billingCity' => $order->city,
            'billingState' => $order->state,
            'billingPostCode' => $order->postcode,
            'email' => $order->email,
        );
        $card = new CreditCard($cardInput);

        $params = array(
            'amount' => (float)$order->totalPrice,
            'currency' => 'NZD',
            'description' => CLIENT . ' purchase',
            'transactionId' => md5($order->uniqueId . time() . uniqid()),
            'transactionReference' => $order->firstname . ' ' . $order->lastname,
            'returnUrl' => $this->app->url('cart-paypal-complete'),
            'cancelUrl' => $this->app->url('cart-paypal-complete'),
            'card' => $card,
        );

        return $params;
    }
}