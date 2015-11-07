<?php

namespace Pz\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Pz\Common\Utils;

class Model implements ControllerProviderInterface {

	public function connect(Application $app) {

		$controllers = $app['controllers_factory'];
		$controllers->match('/', array($this,'models'));
		$controllers->match('/detail/{type}/{returnURL}/', array($this,'model'))->bind('add-model');
		$controllers->match('/detail/{type}/{returnURL}/{id}/', array($this,'model'))->bind('edit-model');
		$controllers->match('/sort/', array($this,'sort'));
		return $controllers;
	
	}

	public function models(Application $app, $type = 0) {

		$models = $app['em']->createQueryBuilder()
			->from('CMS\Entities\PzModel', 'entity')
			->select('entity')
			->where('entity.type = :v1')
			->setParameter('v1', $type)
			->orderBy('entity.rank', 'ASC')
			->getQuery()
			->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
		return $app['twig']->render("models.twig", array('models' => $models,'type' => $type,'returnURL' => \Pz\Common\Utils::getURL()));
	
	}

	public function model(Application $app, Request $request, $type, $returnURL, $id = null) {
		global $CMS_FIELDS_ALIAS, $CMS_FIELDS_META, $CMS_WIDGETS;
		
		ksort($CMS_FIELDS_ALIAS, SORT_NATURAL);
		
		$formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Model(), array(), array());
		$form = $formBuilder->getForm();
		$form->handleRequest($request);
		if ($form->isValid()) {
			
		}
		return $app['twig']->render("model.twig", array(
				'form' => $form->createView(),
				'fields' => $CMS_FIELDS_ALIAS,
				'metas' => $CMS_FIELDS_META,
				'widgets' => $CMS_WIDGETS,
		));
	}

	public function sort(Application $app) {

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