<?php

namespace Pz\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Pz\Common\Utils;

class Model implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/', array($this, 'models'));
        $controllers->match('/{modelType}/{returnURL}/', array($this, 'model'))->bind('add-model');
        $controllers->match('/{modelType}/{returnURL}/{id}/', array($this, 'model'))->bind('edit-model');
        $controllers->match('/sort/', array($this, 'sort'))->bind('sort-models');
        $controllers->match('/{modelType}/', array($this, 'models'));
        return $controllers;
    }

    public function models(Application $app, Request $request, $modelType = 0)
    {
        $models = \Pz\DAOs\Model::data($app['em'], array(
            'whereSql' => 'entity.modelType = :v1',
            'params' => array(
                'v1' => $modelType,
            )
        ));
        return $app['twig']->render("models.twig", array(
            'models' => $models,
            'modelType' => $modelType,
            'returnURL' => 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}",
        ));
    }

    public function model(Application $app, Request $request, $modelType, $returnURL, $id = null)
    {
        $returnURL = urldecode($returnURL);

        global $CMS_FIELDS, $CMS_METAS, $CMS_WIDGETS;

        $fields = $app['em']->getClassMetadata('Pz\Entities\Content')->getFieldNames();
        if ($id) {
            $model = \Pz\DAOs\Model::findById($app['em'], $id);
            if (!$model) {
                throw new NotFoundHttpException();
            }

            $myClass = "\\" . DEFAULT_NAMESPACE . "\\DAOS\\" . $model->className;
            $m = new $myClass($app['em']);
            $fields = $app['em']->getClassMetadata($m->getORMClass())->getFieldNames();

        } else {
            $model = new \Pz\DAOs\Model($app['em']);
            $model->label = 'New models';
            $model->className = 'NewModel';
            $model->modelType = $modelType;
            $model->dataType = 0;
            $model->listType = 0;
            $model->numberPerPage = 25;
            $model->defaultSortBy = 'id';
            $model->defaultOrder = 1;
        }

        $fields = array_diff($fields, $CMS_METAS);
        sort($fields, SORT_NATURAL);
        sort($CMS_METAS, SORT_NATURAL);
        asort($CMS_WIDGETS, SORT_NATURAL);

        $allColumns = array_merge($fields, $CMS_METAS);
        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Model(), $model, array(
            'defaultSortByOptions' => array_combine($allColumns, $allColumns),
        ));
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $model->save();

            $generated = HOME_DIR . '/src/' . DEFAULT_NAMESPACE . '/DAOs/Generated/' . $model->className . '.php';
            $customised = HOME_DIR . '/src/' . DEFAULT_NAMESPACE . '/DAOs/' . $model->className . '.php';
            if (file_exists($generated)) {
                unlink($generated);
            }

            $model->columnsJson = json_decode($model->columnsJson);
            $mappings = array_map(function($value) {
                return "'{$value->field}' => '{$value->column}', ";
            }, $model->columnsJson);
            $str = file_get_contents(__DIR__ . '/_generated.txt');
            $str = str_replace('{TIMESTAMP}', date('Y-m-d H:i:s'), $str);
            $str = str_replace('{NAMESPACE}', DEFAULT_NAMESPACE, $str);
            $str = str_replace('{CLASSNAME}', $model->className, $str);
            $str = str_replace('{MODELID}', $model->id, $str);
            $str = str_replace('{MAPPING}', join("\n\t\t\t", $mappings), $str);
            file_put_contents($generated, $str);

            if (!file_exists($customised)) {
                $str = file_get_contents(__DIR__ . '/_customised.txt');
                $str = str_replace('{TIMESTAMP}', date('Y-m-d H:i:s'), $str);
                $str = str_replace('{NAMESPACE}', DEFAULT_NAMESPACE, $str);
                $str = str_replace('{CLASSNAME}', $model->className, $str);
                file_put_contents($customised, $str);
            }


            if ($request->get('submit') == 'apply') {
                return $app->redirect($app->url('edit-model', array(
                    'modelType' => $model->modelType,
                    'returnURL' => urlencode($returnURL),
                    'id' => $model->id,
                )));
            } else if ($request->get('submit') == 'save') {
                return $app->redirect($returnURL);
            }
        }

        return $app['twig']->render("model.twig", array(
            'form' => $form->createView(),
            'fields' => $fields,
            'metas' => $CMS_METAS,
            'widgets' => $CMS_WIDGETS,
            'id' => $id,
            'returnURL' => $returnURL,
        ));
    }

    public function sort(Application $app, Request $request)
    {
        $data = json_decode($request->get('data'));
        foreach ($data as $key => $value) {
            $model = \Pz\DAOs\Model::findById($app['em'], $value);
            if ($model) {
                $model->rank = $key;
                $model->save();
            }
        }
        return new Response('OK');
    }

}