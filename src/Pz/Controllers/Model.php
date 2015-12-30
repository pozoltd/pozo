<?php

namespace Pz\Controllers;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
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
        $controllers->match('/detail/{modelType}/{returnURL}/', array($this, 'model'))->bind('add-model');
        $controllers->match('/detail/{modelType}/{returnURL}/{id}/', array($this, 'model'))->bind('edit-model');
        $controllers->match('/sort/', array($this, 'sort'));
        return $controllers;

    }

    public function models(Application $app, $type = 0)
    {

        $models = $app['em']->createQueryBuilder()
            ->from('Pz\Entities\Model', 'entity')
            ->select('entity')
            ->where('entity.type = :v1')
            ->setParameter('v1', $type)
            ->orderBy('entity.rank', 'ASC')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        return $app['twig']->render("models.twig", array('models' => $models, 'type' => $type, 'returnURL' => \Pz\Common\Utils::getURL()));

    }

    public function model(Application $app, Request $request, $modelType, $returnURL, $id = null)
    {
        global $CMS_FIELDS, $CMS_METAS, $CMS_WIDGETS;

        ksort($CMS_FIELDS, SORT_NATURAL);
        sort($CMS_METAS, SORT_NATURAL);
        asort($CMS_WIDGETS, SORT_NATURAL);

        if ($id) {
            $repo = $app['em']->getRepository('\Pz\Entities\Model');
            $model = $repo->find($id);
        } else {
            $model = new \Pz\Entities\Model();
            $model->setLabel('New models');
            $model->setClassName('NewModel');
            $model->setModelType($modelType);
            $model->setDataType(0);
            $model->setListType(1);
            $model->setNumberPerPage(25);
            $model->setDefaultSortBy('id');
            $model->setDefaultOrder(0);
        }
        if (!$model) {
            throw new NotFoundHttpException();
        }


        $allColumns = array_merge(array_values($CMS_FIELDS), $CMS_METAS);
        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Model(), $model, array(
            'defaultSortByOptions' => array_combine($allColumns, $allColumns),
        ));
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
//            var_dump($model->getDefaultSortBy());exit;
            $model->setRank(1);
            $app['em']->persist($model);
            $app['em']->flush();
            return $app->redirect($app->url('edit-model', array(
                'modelType' => $model->getModelType(),
                'returnURL' => $returnURL,
                'id' => $model->getId(),
            )));
        }

        return $app['twig']->render("model.twig", array(
            'form' => $form->createView(),
            'fields' => $CMS_FIELDS,
            'metas' => $CMS_METAS,
            'widgets' => $CMS_WIDGETS,
        ));
    }

    public function sort(Application $app)
    {

        $request = $app['request'];
        $data = json_decode($request->get('data'));
        $repo = $app['em']->getRepository('CMS\Entities\Model');
        foreach ($data as $idx => $itm) {
            $entity = $repo->find($itm);
            if ($entity) {
                $entity->setRank($idx);
                $app['em']->persist($entity);
            }
        }
        $app['em']->flush();
        return new Response('Success');

    }

}