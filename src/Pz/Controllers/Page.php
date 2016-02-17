<?php
namespace Pz\Controllers;

use Pz\Common\Utils;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Page implements ControllerProviderInterface {

	public function connect(Application $app) {
		$content = array();
		$controllers = $app['controllers_factory'];
		$controllers->match('/', array($this,'pages'))->bind('pages');
		$controllers->match('/remove/', array($this,'remove'))->bind('remove-page');
		$controllers->match('/count/', array($this,'count'))->bind('count-pages');
		$controllers->match('/change/', array($this,'change'))->bind('change-category');
		$controllers->match('/sort/', array($this,'sort'))->bind('sort-pages');
		return $controllers;
	}
	
	
	
	public function pages(Application $app, Request $request) {
		var_dump(123);exit;
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		$categories = $repo->data('Page category', '', array(), array('sort' => 'rank', 'order' => 'ASC'));
		$cat = $request->get('cat');
		if (!$cat && count($categories['_data']) > 0) {
			$cat = $categories['_data'][0]['id'];
		}
		$cat = $cat;
		
		$result = $repo->data('Page', '', array(), array());
		$pages = array();
		foreach ($result['_data'] as $itm) {
			$itm['catRank'] = ((empty($itm['catRank']) || !$itm['catRank'])) ? array() : (array)json_decode($itm['catRank']);
			$itm['catParent'] = ((empty($itm['catParent']) || !$itm['catParent'])) ? array() : (array)json_decode($itm['catParent']);
			$itm['category'] = ((empty($itm['category']) || !$itm['category'])) ? array() : (array)json_decode($itm['category']);
			
			$itm['rank'] = isset($itm['catRank']['cat' . $cat]) ? $itm['catRank']['cat' . $cat] : 0;
			$itm['parentId'] = isset($itm['catParent']['cat' . $cat]) ? $itm['catParent']['cat' . $cat] : 0;
			if ($cat == -1 && count($itm['category']) == 0) {
				$pages[] = $itm;
			} else if (in_array($cat, $itm['category'])){
				$pages[] = $itm;
			}
		}
		
		usort($pages, function($a, $b) {
			return $a["rank"] > $b["rank"] ? 1 : -1;
		});
		
		$root = Utils::buildTree(array('id' => 0), $pages);
		return $app['twig']->render("pages.twig", array(
			'_menu' => 'pages',
			'root' => $root, 
			'returnURL' => Utils::getURL(),
			'cat' => $cat
		));
	}
	
	public function remove(Application $app, Request $request) {
		$modelName = $request->get('modelName');
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		$model = $repo->model(urldecode($modelName));
		$user = $app['user']->getUser();
		if ((!$user || $user->admin == 0) && $model['permission'] == 1) {
			return $app->abort(401);
		}
		
		$id = $request->request->get('id');
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		$result = $repo->data('Page', '', array(), array('sort' => 'rank', 'order' => 'ASC'));
		$root = Utils::buildTree(array('id' => 0), $result['_data']);
		$ids = Utils::withChildIds($root, $id);
		foreach ($ids as $itm) {
			$entity = $repo->find($itm);
			$app['em']->remove($entity);
		}
		$app['em']->flush();
		return new Response('Success');
	}
	
	public function count(Application $app, Request $request) {
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		$result = $repo->data('Page', '', array(), array());
		$counter = array();
		foreach ($result['_data'] as $itm) {
			$itm['category'] = ((empty($itm['category']) || !$itm['category'])) ? array() : (array)json_decode($itm['category']);
			if (count($itm['category']) > 0) {
				foreach ($itm['category'] as $itm2) {
					if (isset($counter['cat' . $itm2])) {
						$counter['cat' . $itm2]++;
					} else {
						$counter['cat' . $itm2] = 1;
					}
				}
			} else {
				if (isset($counter['cat-1'])) {
					$counter['cat-1']++;
				} else {
					$counter['cat-1'] = 1;
				}
			}
		}
		return new Response(json_encode($counter));
	}
	
	public function change(Application $app, Request $request) {
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		
		
		$result = $repo->data('Page', '', array(), array());
		$pages = array();
		foreach ($result['_data'] as $itm) {
			$itm['catRank'] = ((empty($itm['catRank']) || !$itm['catRank'])) ? array() : (array)json_decode($itm['catRank']);
			$itm['catParent'] = ((empty($itm['catParent']) || !$itm['catParent'])) ? array() : (array)json_decode($itm['catParent']);
			$itm['category'] = ((empty($itm['category']) || !$itm['category'])) ? array() : (array)json_decode($itm['category']);
				
			$itm['rank'] = isset($itm['catRank']['cat' . $request->get('oldCat')]) ? $itm['catRank']['cat' . $request->get('oldCat')] : 0;
			$itm['parentId'] = isset($itm['catParent']['cat' . $request->get('oldCat')]) ? $itm['catParent']['cat' . $request->get('oldCat')] : 0;
			if ($request->get('oldCat') == -1 && count($itm['category']) == 0) {
				$pages[] = $itm;
			} else if (in_array($request->get('oldCat'), $itm['category'])){
				$pages[] = $itm;
			}
		}
		$root = Utils::buildTree(array('id' => 0), $pages);
		
		$result = $repo->data('Page', '', array(), array());
		$ids = Utils::withChildIds($root, $request->get('id'));
		foreach ($ids as $itm) {
			if ($itm != $request->get('id')) {
				foreach ($result['_data'] as &$itm2) {
					$itm2['catRank'] = ((empty($itm2['catRank']) || !$itm2['catRank'])) ? array() : (array)json_decode($itm2['catRank']);
					$itm2['catParent'] = ((empty($itm2['catParent']) || !$itm2['catParent'])) ? array() : (array)json_decode($itm2['catParent']);
					$itm2['category'] = (empty($itm2['category']) || !$itm2['category']) ? array() : json_decode($itm2['category']);
					
					if ($itm2['id'] == $itm) {
						$itm2['catRank']['cat' . $request->get('newCat')] = $itm2['catRank']['cat' . $request->get('oldCat')];
						$itm2['catParent']['cat' . $request->get('newCat')] = $itm2['catParent']['cat' . $request->get('oldCat')];
						
						$categories = array();
						foreach ($itm2['category'] as $itm3) {
							if ($request->get('oldCat') != $itm3) {
								$categories[] = $itm3;
							}
						}
						$itm2['category'] = $categories;
						if (!in_array($request->get('newCat'), $itm2['category'])) {
							$itm2['category'][] = $request->get('newCat');
						}
					}
					
					$itm2['catRank'] = json_encode($itm2['catRank']);
					$itm2['catParent'] = json_encode($itm2['catParent']);
					$itm2['category'] = json_encode($itm2['category']);
				}
			}
		}
		$repo->save($result);
		
		$result = $repo->data('Page', 'entity.id = :v1', array('v1' => $request->get('id')), array());
		if (count($result['_data']) == 1) {
			$result['_data'][0]['category'] = (empty($result['_data'][0]['category']) || !$result['_data'][0]['category']) ? array() : json_decode($result['_data'][0]['category']);
			$categories = array();
			foreach ($result['_data'][0]['category'] as $itm) {
				if ($request->get('oldCat') != $itm) {
					$categories[] = $itm;
				}
			}
			$result['_data'][0]['category'] = $categories;
			if (!in_array($request->get('newCat'), $result['_data'][0]['category'])) {
				$result['_data'][0]['category'][] = $request->get('newCat');
			}
			
			$result['_data'][0]['catRank'] = ((empty($result['_data'][0]['catRank']) || !$result['_data'][0]['catRank'])) ? array() : (array)json_decode($result['_data'][0]['catRank']);
			$result['_data'][0]['catParent'] = ((empty($result['_data'][0]['catParent']) || !$result['_data'][0]['catParent'])) ? array() : (array)json_decode($result['_data'][0]['catParent']);
			
			$result['_data'][0]['catRank']['cat' . $request->get('newCat')] = 0;
			$result['_data'][0]['catParent']['cat' . $request->get('newCat')] = 0;
			
			$result['_data'][0]['catRank'] = json_encode($result['_data'][0]['catRank']);
			$result['_data'][0]['catParent'] = json_encode($result['_data'][0]['catParent']);
			
			$repo->save($result);
		}
		return new Response('OK');
	}
	

	public function sort(Application $app, Request $request) {
		$repo = $app['em']->getRepository('Secret\Entities\Content');
		$result = $repo->data('Page', '', array(), array());
		$data = json_decode($request->get('data'));
		foreach ($result['_data'] as &$itm) {
			$itm['catRank'] = ((empty($itm['catRank']) || !$itm['catRank'])) ? array() : (array)json_decode($itm['catRank']);
			$itm['catParent'] = ((empty($itm['catParent']) || !$itm['catParent'])) ? array() : (array)json_decode($itm['catParent']);
			$itm['category'] = ((empty($itm['category']) || !$itm['category'])) ? array() : (array)json_decode($itm['category']);
			foreach ($data as $itm2) {
				$itm2 = (array)$itm2;
				if ($itm['id'] == $itm2['id']) {
					$itm['catRank']['cat' . $request->get('cat')] = $itm2['rank'];
					$itm['catParent']['cat' . $request->get('cat')] = $itm2['parentId'];
				}
			}
			$itm['catRank'] = json_encode($itm['catRank']);
			$itm['catParent'] = json_encode($itm['catParent']);
			$itm['category'] = json_encode($itm['category']);
		}
		$repo->save($result);
		return new Response('OK');
	}
}