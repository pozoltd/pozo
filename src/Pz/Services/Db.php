<?php
namespace Pz\Services;

use Pz\Common\Utils;
use Silex\ServiceProviderInterface;
use Silex\Application;

class Db implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['db'] = $this;
    }

    public function boot(Application $app)
    {
        $this->app = $app;
    }

    public function active($className, $options = array())
    {
        $model = $this->model($className);
        $className = $model->getFullClass();
        var_dump(count($className::active($this->app['em'], $options)));exit;
        return $className::active($this->app['em'], $options);
    }

    public function data($className, $options = array())
    {
        $model = $this->model($className);
        $className = $model->getFullClass();
        return $className::data($this->app['em'], $options);
    }

    public function getById($className, $id)
    {
        $model = $this->model($className);
        $className = $model->getFullClass();
        return $className::findById($this->app['em'], $id);
    }

    public function getBySlug($className, $slug)
    {
        $model = $this->model($className);
        $className = $model->getFullClass();
        return $className::findBySlug($this->app['em'], $slug);
    }

    public function getByField($className, $field, $value)
    {
        $model = $this->model($className);
        $className = $model->getFullClass();
        return $className::data($this->app['em'], array(
            'whereSql' => 'entity.' . $field . ' = :v1',
            'params' => array(
                'v1' => $value,
            ),
            'oneOrNull' => true,
        ));
    }

    private function model($className) {
        if ($className == 'Model') {
            $model = new \Pz\Database\Model($this->app['em']);
            $model->namespace = 'Pz\\Database';
            $model->className = $className;
        } else {
            $model = \Pz\Database\Model::data($this->app['em'], array(
                'whereSql' => 'entity.className = :v1',
                'params' => array(
                    'v1' => $className
                ),
                'oneOrNull' => true,
            ));
            if (!$model) {
                $this->app->abort(404, "Model $className does not exist");
            }
        }
        return $model;
    }
}
