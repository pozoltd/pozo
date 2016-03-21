<?php
namespace Pz\Services;

use Pz\Common\Utils;
use Silex\ServiceProviderInterface;
use Silex\Application;

class Form implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['form'] = $this;
    }

    public function boot(Application $app)
    {
        $this->app = $app;
    }


    public function getForm($code)
    {

        $formDescriptor = \Site\DAOs\FormDescriptor::findByField($this->app['em'], 'code', $code);
        if (is_null($formDescriptor)) {
            $this->app->abort(404);
        }
        $formDescriptor->sent = false;

        $formBuilder = new \Pz\Services\FormBuilder($formDescriptor, $this->app, array());
        $form = $this->app['form.factory']->create(
            $formBuilder, array()
        );

        $request = $this->app['request'];
        if ('POST' == $request->getMethod()) {// we need to make sure we have some sort of token before handling a post, look for csrf

            $form->bind($request);
            $data = $form->getData();
            $formDescriptor->posted = true;

            if ($form->isValid()) {

                $messageBody = $this->app['twig']->render('email.twig', array(
                    'formDescriptor' => $formDescriptor,
                    'data' => $data,
                ));
                $message = \Swift_Message::newInstance()
                    ->setSubject(CLIENT . ' EMAIL#' )
                    ->setFrom(array($formDescriptor->from))
                    ->setTo(array_filter(array_map('trim', explode(',', $formDescriptor->recipients))))
                    ->setBcc(array(EMAIL_BCC))
                    ->setBody(
                        $messageBody, 'text/html'
                    );
                $formDescriptor->sent = $this->app['mailer']->send($message);
            }
        }


        $formDescriptor->form = $form->createView();
        return $formDescriptor;

    }
}
