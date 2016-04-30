<?php
namespace Pz\Services;

use Pz\Common\Utils;
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

    public function getEncodedURL()
    {
        return Utils::encodeURL(Utils::getURL());
    }

    public function system($code)
    {
        if ($setting = \Site\DAOs\SystemSetting::findByField($this->app['em'], 'code', $code)) {
            return $setting->value;
        }
        $this->app->abort(404);
    }

    public function active($className, $options = array(), $namespace = 'Site')
    {
        $className = "\\{$namespace}\\DAOs\\{$className}";
        return $className::active($this->app['em'], $options);
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

    public function getBySlug($className, $slug, $namespace = 'Site')
    {
        $className = "\\{$namespace}\\DAOs\\{$className}";
        return $className::findBySlug($this->app['em'], $slug);
    }

    public function getByField($className, $field, $value, $namespace = 'Site')
    {
        $className = "\\{$namespace}\\DAOs\\{$className}";
        $result = $className::data($this->app['em'], array(
            'whereSql' => 'entity.' . $field . ' = :v1',
            'params' => array(
                'v1' => $value,
            )
        ));
        return count($result) > 0 ? $result[0] : null;
    }

    public function getRequestURI() {
        return stripos(Utils::getURL(), '?') === false ? '' : substr(Utils::getURL(), stripos(Utils::getURL(), '?'));
    }

    public function getFormWidgets() {
        global $FORM_WIDGETS;
        return $FORM_WIDGETS;
    }

    public function getFormData($value) {
        if ($value[2] == 'textarea') {
            return nl2br($value[1]);
        } else if ($value[2] == '\Pz\Twig\Types\Wysiwyg') {
            return $value[1];
        }
        return strip_tags($value[1]);
    }

    public function root($categoryCode) {
        $category = \Site\DAOs\PageCategory::findByField($this->app['em'], 'code', $categoryCode);
        $cat = $category->id;
        $result = \Site\DAOs\Page::data($this->app['em']);
        $pages = array();
        foreach ($result as $itm) {
            $itm->categoryRank = ((empty($itm->categoryRank) || !$itm->categoryRank)) ? array() : (array)json_decode($itm->categoryRank);
            $itm->categoryParent = ((empty($itm->categoryParent) || !$itm->categoryParent)) ? array() : (array)json_decode($itm->categoryParent);
            $itm->category = ((empty($itm->category) || !$itm->category)) ? array() : (array)json_decode($itm->category);

            $itm->rank = isset($itm->categoryRank['cat' . $cat]) ? $itm->categoryRank['cat' . $cat] : 0;
            $itm->parentId = isset($itm->categoryParent['cat' . $cat]) ? $itm->categoryParent['cat' . $cat] : 0;
            if ($cat == -1 && count($itm->category) == 0) {
                $pages[] = $itm;
            } else if (in_array($cat, $itm->category)){
                $pages[] = $itm;
            }
        }

        usort($pages, function($a, $b) {
            return $a->rank > $b->rank ? 1 : -1;
        });

        $root = new \stdClass();
        $root->id = 0;
        $root = Utils::buildTree($root, $pages);
        return $root;
    }
}
