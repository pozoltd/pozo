<?php

namespace Pz\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Pz\Common\Utils;

class Content implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/{modelId}/', array($this, 'contents'));
        $controllers->match('/add/{modelId}/{returnURL}/', array($this, 'content'))->bind('add-content');
        $controllers->match('/edit/{modelId}/{returnURL}/{id}/', array($this, 'content'))->bind('edit-content');
        return $controllers;
    }

    public function contents(Application $app, Request $request, $modelId)
    {
        $model = \Pz\DAOs\Model::findById($app['em'], $modelId);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $daoClass = DEFAULT_NAMESPACE . '\\DAOs\\' . $model->className;
        $daos = $daoClass::data($app['em'], array(
            'sort' => 'entity.' . ($request->get('sort') ?: $model->defaultSortBy),
            'order' => $request->get('order') ?: $model->defaultOrder == 1 ? 'DESC' : 'ASC',
        ));
        return $app['twig']->render("contents.twig", array(
            'model' => $model,
            'contents' => $daos,
            'returnURL' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
        ));
    }

    public function content(Application $app, Request $request, $modelId, $returnURL, $id = null)
    {
        $model = \Pz\DAOs\Model::findById($app['em'], $modelId);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        $daoClass = DEFAULT_NAMESPACE . '\\DAOs\\' . $model->className;
        $content = new $daoClass($app['em']);
        if ($id) {
            $content = $daoClass::findById($app['em'], $id);
            if (!$content) {
                throw new NotFoundHttpException();
            }
        }
//        Utils::dump($content->active);exit;

        $form = $app['form.factory']->createBuilder('form', $content);
        $model->columnsJson = json_decode($model->columnsJson);
        foreach ($model->columnsJson as $itm) {
            $widget = $itm->widget;
            if (strpos($itm->widget, '\\') !==  FALSE) {
                $wgtClass = $itm->widget;
                $widget = new $wgtClass();

            }
            $options = array(
                'label' => $itm->label,
            );
            if ($itm->widget == 'choice' || $itm->widget == '\\Pz\\Twig\\Types\\ChoiceMultiJson') {
                $conn = $app['em']->getConnection();
                $stmt = $conn->executeQuery($itm->sql);
                $stmt->execute();
                $choices = array();
                foreach ($stmt->fetchAll() as $key => $val) {
                    $choices[$val['key']] = $val['value'];
                }
                $options['choices'] = $choices;

            }
            if ($itm->required == 1) {
                $options['constraints'] = array(
                    new Assert\NotBlank(),
                );
            }
            $form->add($itm->field, $widget, $options);

        }
        $form = $form->getForm();
//        Utils::dump($form);exit;

        if ($request->isMethod("POST")) {
            $form->bind($request);
            if ($form->isValid()) {
                $content->save();

                if ($request->request->get('submit') == 'Save') {
                    return $app->redirect(urldecode($returnURL));
                } else {
                    return $app->redirect($app->url('edit-content', array('modelId' => $modelId, 'returnURL' => $returnURL, 'id' => $content->id)));
                }
            }
        }

        return $app['twig']->render("content.twig", array(
            'form' => $form->createView(),
            'model' => $model,
            'content' => $content,
            'returnURL' => urldecode($returnURL),
        ));
    }
}