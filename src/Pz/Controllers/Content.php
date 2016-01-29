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
        $controllers->match('/{modelId}/', array($this, 'data'));
        return $controllers;
    }

    public function data(Application $app, $modelId)
    {
//        var_dump(new \Site\Entities\User());exit;

        $conn = $app['em']->getConnection();
        $sql = "SELECT * FROM contents WHERE modelId = 2";
        $stmt = $conn->query($sql);

        while ($row = $stmt->fetch()) {
            echo $row['text1'] . '<br>';
        }
        exit;

        $user = new \Site\Entities\User();
        $user->setText1('a');
        $user->setText2('b');
        $user->setSlug('a');
        $user->setModelId(1);
        $user->setActive(1);
        $user->setRank(1);
        $user->setParentId(0);
        $user->setAdded(new \DateTime('now'));
        $user->setModified(new \DateTime('now'));
        $app['em']->persist($user);
        $app['em']->flush();


        $test = new \Site\Entities\Test();
        $test->setText1('test');
        $test->setSlug('test');
        $test->setModelId(2);
        $test->setActive(1);
        $test->setRank(1);
        $test->setParentId(0);
        $test->setAdded(new \DateTime('now'));
        $test->setModified(new \DateTime('now'));
        $app['em']->persist($test);
        $app['em']->flush();

        $repo =$app['em']->getRepository('\Site\Entities\Test');
        var_dump($repo->findBy(array('modelId' => 2)));
        exit;
        return $app['twig']->render("contents.twig", array());
    }

}