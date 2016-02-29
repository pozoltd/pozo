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

class Router implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('{url}', array($this, 'route'))->assert('url', '.*');
        return $controllers;
    }

    public function route(Application $app, Request $request, $url)
    {
        //Looking for exact match first, start without /
        $page = \Site\DAOs\Page::findByField($app['em'], 'url', trim($url, '/'));
        if (!$page) {
            $page = \Site\DAOs\Page::findByField($app['em'], 'url', trim($url, '/') . '/');
        }
        if ($page) {
            return $app['twig']->render($page->template, array(
                'pageBuilder' => $page,
            ));
        }

        //If no exact match, start looking for closest
        $url = rtrim($url, '/');
        $args = explode('/', $url);
        for ($i = count($args), $il = 0; $i > $il; $i--) {
            //Gradually, take out last piece
            $parts = array_slice($args, 0, $i);

            //Start compare with / (because no exact match found)
            $page = \Site\DAOs\Page::findByField($app['em'], '/' . implode('/', $parts) . '/', $this->zdb);
            if (!$page) {
                $page = \Site\DAOs\Page::findByField($app['em'], '/' . implode('/', $parts), $this->zdb);
            }

            if ($page) {
                $page->args = array_slice($args, $i);
                break;
            }
        }

        return $app['twig']->render($page->template, array(
            'pageBuilder' => $page,
        ));
    }

}