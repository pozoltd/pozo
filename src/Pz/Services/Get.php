<?php
namespace Pz\Services;

use Silex\ServiceProviderInterface;
use Silex\Application;

class Get implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['get'] = $this;
    }

    public function boot(Application $app)
    {
        $this->app = $app;
    }

    public function data($className, $options = array(), $namespace = 'Site')
    {
        $className = "\\{$namespace}\\DAOs\\{$className}";
        return $className::data($this->app['em'], $options);
    }

    public function getById($className, $id, $namespace = 'Site')
    {
        $className = "\\{$namespace}\\DAOs\\{$className}";
        return $className::findById($this->app['em'], $id);
    }
}
