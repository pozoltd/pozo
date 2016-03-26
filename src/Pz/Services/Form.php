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
            if ($form->isValid()) {
                $data = $form->getData();

                $result = array();
                foreach (json_decode($formDescriptor->fields) as $field) {
                    $result[$field->label] = $data[$field->id];
                }

                $code = uniqid();
                $submission = new \Site\DAOs\FormSubmission($this->app['em']);
                $submission->title = '#' . $code . ' ' . $data['email'];
                $submission->uniqueId = $code;
                $submission->date = date('Y-m-d H:i:s');
                $submission->from = $formDescriptor->from;
                $submission->recipients = $formDescriptor->recipients;
                $submission->content = json_encode($result);
                $submission->emailStatus = 0;
                $submission->save();

                $messageBody = $this->app['twig']->render('email.twig', array(
                    'submission' => $submission,
                    'result' => $result,
                ));
                $message = \Swift_Message::newInstance()
                    ->setSubject(CLIENT . ' EMAIL#' . $submission->uniqueId)
                    ->setFrom(array($formDescriptor->from))
                    ->setTo(array_filter(array_map('trim', explode(',', $formDescriptor->recipients))))
                    ->setBcc(array(EMAIL_BCC))
                    ->setBody(
                        $messageBody, 'text/html'
                    );
                $formDescriptor->sent = $this->app['mailer']->send($message);

                $submission->emailStatus = $formDescriptor->sent ? 1 : 2;
                $submission->emailRequest = $messageBody;
                $submission->emailResponse = $formDescriptor->sent;
                $submission->save();
            }
        }


        $formDescriptor->form = $form->createView();
        return $formDescriptor;

    }
}