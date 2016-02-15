<?php
namespace Pz\Controllers;

use Imagick;
use Secret\Common\Utils;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class Asset implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];
        $controllers->match('/', array($this, 'assets'))->bind('assets');
        $controllers->match('/folder/info/{id}/', array($this, 'folder'))->bind('find-by-folder-id');
        $controllers->match('/upload/', array($this, 'upload'))->bind('upload-assets');
        $controllers->match('/download/{id}/', array($this, 'download'))->bind('download-assets');
        $controllers->match('/image/{id}/', array($this, 'image'))->bind('view-image-original');
        $controllers->match('/image/{id}/{size}/', array($this, 'image'))->bind('view-image');

        $controllers->match('/{id}/', array($this, 'assets'))->bind('assets-folder');

        return $controllers;
    }

    private function _ancestors($all, $currentId, &$result)
    {
        foreach ($all['_data'] as $itm) {
            if ($currentId == $itm['id']) {
                array_unshift($result, $itm);
                $this->_ancestors($all, $itm['parentId'], $result);
            }
        }
    }

    public function folder(Application $app, Request $request, $id)
    {
        $repo = $app['em']->getRepository('Secret\Entities\Content');
        $folders = $repo->data('Asset', 'entity.id = :v1', array(
            'v1' => $id
        ));
        if (count($folders['_data']) > 0) {
            $images = $repo->data('Asset', 'entity.parentId = :v1', array(
                'v1' => $folders['_data'][0]['id']
            ));
        }

        return json_encode(array($folders, $images));
    }

    public function assets(Application $app, Request $request, $id = 0, $view = '')
    {
        $newFolder = new \Site\DAOs\Asset($app['em']);
        $newFolder->isFolder = 1;
        $newFolder->parentId = $id;
        $formBuilder = $app['form.factory']->createBuilder(new \Pz\Forms\Folder(), $newFolder);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);
        if ($form->isValid()) {
            $id = $newFolder->save();
            return $app->redirect($app->url('assets-folder', array('id' => $id)));
        }

        $folders = \Site\DAOs\Asset::data($app['em'], array(
            'whereSql' => 'entity.parentId = :v1 AND entity.isFolder = 1',
            'params' => array(
                'v1' => $id
            ),
        ));

        $files = \Site\DAOs\Asset::data($app['em'], array(
            'whereSql' => 'entity.parentId = :v1 AND entity.isFolder != 1',
            'params' => array(
                'v1' => $id
            ),
        ));

        return $app['twig']->render('assets.twig', array(
            'form' => $form->createView(),

            'currentId' => $id,
            'folders' => $folders,
            'files' => $files,
			'ancestors' => array(),
			'view' => $view,
			'returnURL' => '',
			'CKEditorFuncNum' => $request->request->get('CKEditorFuncNum') ? $request->request->get('CKEditorFuncNum') : $request->get('CKEditorFuncNum')
        ));
//		$view = $request->get('view') ? $request->get('view') : '';
//
//		$repo = $app['em']->getRepository('Secret\Entities\Content');
//		if ($request->getMethod() == 'POST') {
//			$model = $repo->create('Asset');
//			$model['_data'][0]['name'] = $request->request->get('name');
//			$model['_data'][0]['isFolder'] = 1;
//			$model['_data'][0]['parentId'] = $request->request->get('parentId');
//			$model['_data'][0]['fileSize'] = 1;
//			$repo->save($model);
//			if (!$view || empty($view)) {
//				return $app->redirect('/secret/assets/folder/' . $model['_data'][0]['id'] . '/');
//			}
//		}
//		$current = $repo->data('Asset', 'entity.id = :v1', array(
//			'v1' => $id
//		));
//		$currentId = count($current['_data']) > 0 ? $current['_data'][0]['id'] : 0;
//		$ancestors = array();
//		$this->_ancestors($repo->data('Asset', 'entity.isFolder = 1'), $currentId, $ancestors);
//		$folders = $repo->data('Asset', 'entity.parentId = :v1 AND entity.isFolder = 1', array(
//			'v1' => $id
//		), array(
//			'sort' => 'rank',
//			'order' => 'ASC'
//		));
//		foreach ($folders['_data'] as &$itm) {
//			$result = $repo->data('Asset', 'entity.parentId = :v1', array(
//				'v1' => $itm['id']
//			));
//			$itm['_childNum'] = count($result['_data']);
//		}
//
//		$files = $repo->data('Asset', 'entity.parentId = :v1 AND entity.isFolder = 0', array(
//			'v1' => $id
//		), array(
//			'sort' => 'rank',
//			'order' => 'ASC'
//		));
//		return $app['twig']->render('assets' . (($view == '') ? '' : '-' . $view) . '.twig', array(
//			'_menu' => 'assets',
//			'currentId' => $currentId,
//			'folders' => $folders,
//			'files' => $files,
//			'ancestors' => $ancestors,
//			'view' => $view,
//			'returnURL' => \Secret\Common\Utils::getURL(),
//			'CKEditorFuncNum' => $request->request->get('CKEditorFuncNum') ? $request->request->get('CKEditorFuncNum') : $request->get('CKEditorFuncNum')
//		));
    }

    public function upload(Application $app, Request $request)
    {
        $files = $request->files->get('files');
        if ($files && is_array($files) && count($files) > 0) {
            $repo = $app['em']->getRepository('Secret\Entities\Content');
            $originalName = $files[0]->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            $model = $repo->create('Asset');
            $model['_data'][0]['name'] = $originalName;
            $model['_data'][0]['isFolder'] = 0;
            $model['_data'][0]['parentId'] = $request->request->get('parentId');
            $model['_data'][0]['fileSize'] = 0;
            $repo->save($model);

            require_once SECRET . '/vendor/blueimp/jquery-file-upload/server/php/UploadHandler.php';
            $uploader = new \UploadHandler(array(
                'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/',
                'image_versions' => array()
            ), false);
            $_SERVER['HTTP_CONTENT_DISPOSITION'] = $model['_data'][0]['id'];
            $result = $uploader->post(false);

            $model = $repo->data('Asset', 'entity.id = :v1', array('v1' => $model['_data'][0]['id']));
            $model['_data'][0]['nameOnServer'] = $model['_data'][0]['id'] . '.' . $ext;
            $model['_data'][0]['fileExt'] = $ext;
            $model['_data'][0]['fileType'] = $result['files'][0]->type;
            $model['_data'][0]['fileSize'] = $result['files'][0]->size;
            $repo->save($model);

            if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $result['files'][0]->name)) {
                rename(dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $result['files'][0]->name, dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $model['_data'][0]['id'] . '.' . $ext);
            }

            return new Response(json_encode($model['_data'][0]));
        }
        return new Response(json_encode(array(
            'failed'
        )));
    }

    public function image(Application $app, Request $request, $id, $size = null)
    {
        $repo = $app['em']->getRepository('Secret\Entities\Content');
        $content = $repo->data('Asset', 'entity.id = ' . $id);
        if (count($content['_data']) == 0) {
            $app->abort(404);
        }
        $fileType = $content['_data'][0]['fileType'];
        $fileName = $content['_data'][0]['name'];
        $file = dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $content['_data'][0]['nameOnServer'];
        if ((file_exists($file) && getimagesize($file) && $size) || ('application/pdf' == $fileType)) {
            $size = $repo->data('Thumbnail size', 'entity.width = :v1', array(
                'v1' => $size
            ));
            if (count($size['_data']) == 0) {
                $app->abort(404);
            }
            $cache = dirname($_SERVER['SCRIPT_FILENAME']) . '/../cache/image/';
            if (!file_exists($cache)) {
                mkdir($cache, 0777, true);
            }
            $thumbnail = $cache . md5($content['_data'][0]['id'] . '-' . $size['_data'][0]['width']) . (('application/pdf' == $fileType) ? '.jpg' : '.' . $content['_data'][0]['fileExt']);
            // if (! file_exists($thumbnail)) {
            // $myfile = fopen($file, "r") or die("Unable to open file!");
            // $in = fread($myfile, filesize($file));
            // $descriptorspec = array(0 => array("pipe","r"),1 => array("pipe","w"),2 => array("file",$cache . '/error.log','a'));
            // $process = proc_open(IMAGICK . ' ' . $file . ' -strip -interlace Plane -gaussian-blur 0.05 -quality 85% -resize "' . $size['_data'][0]['width'] . 'x' . $size['_data'][0]['width'] . '>" ' . $thumbnail, $descriptorspec, $pipes);
            // if (is_resource($process)) {
            // fwrite($pipes[0], $in);
            // fclose($pipes[0]);
            // fclose($pipes[1]);
            // proc_close($process);
            // }
            // }
            if (!file_exists($thumbnail)) {
                if ('application/pdf' == $fileType) {
                    $image = new imagick($file . '[0]');
                    $image->setImageFormat('jpg');
                    $image->setColorspace(imagick::COLORSPACE_RGB);
                    $image->thumbnailImage($size['_data'][0]['width'], null);
                    $image->writeImage($thumbnail);
                } else {
                    $image = new Imagick($file);
                    $image->adaptiveResizeImage($size['_data'][0]['width'], 0);
                    $image->writeImage($thumbnail);
                }
            }
            $file = $thumbnail;
        }
        if (!file_exists($file) || !getimagesize($file)) {
            $file = dirname($_SERVER['SCRIPT_FILENAME']) . '/../../_cdn/htdocs/default/images/noimage.jpg';
        }
        $stream = function () use ($file) {
            readfile($file);
        };
        return $app->stream($stream, 200, array(
            'Content-Type' => 'image/jpg',
            'Content-length' => filesize($file),
            'Content-Disposition' => 'filename="' . $fileName . '"'
        ));
    }

    public function download(Application $app, $id)
    {
        $repo = $app['em']->getRepository('Secret\Entities\Content');
        $content = $repo->data('Asset', 'entity.id = ' . $id);
        if (count($content['_data']) == 0) {
            $app->abort(404, "Asset not found");
        }
        $fileType = $content['_data'][0]['fileType'];
        $fileName = $content['_data'][0]['name'];
        $file = dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $content['_data'][0]['nameOnServer'];
        if (!file_exists($file)) {
            $app->abort(404, "File not found");
        }
        $stream = function () use ($file) {
            readfile($file);
        };
        return $app->stream($stream, 200, array(
            'Content-Type' => $fileType,
            'Content-length' => filesize($file),
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"'
        ));
    }
}