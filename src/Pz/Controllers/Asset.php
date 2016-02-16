<?php
namespace Pz\Controllers;

use Imagick;
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
        $controllers->match('/image/{imageAsset}/{imageSize}/', array($this, 'image'))->bind('image');
        $controllers->match('/image/{imageAsset}/', array($this, 'image'))->bind('image-original');
        $controllers->match('/download/{imageAsset}/', array($this, 'download'))->bind('download-assets');
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
            $newFolder->save();
            return $app->redirect($app->url('assets-folder', array('id' => $newFolder->id)));
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
			'returnURL' => '123',
			'CKEditorFuncNum' => $request->request->get('CKEditorFuncNum') ? $request->request->get('CKEditorFuncNum') : $request->get('CKEditorFuncNum')
        ));

    }

    public function upload(Application $app, Request $request)
    {
        $files = $request->files->get('files');
        if ($files && is_array($files) && count($files) > 0) {
            $originalName = $files[0]->getClientOriginalName();
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);

            $newFile = new \Site\DAOs\Asset($app['em']);
            $newFile->isFolder = 0;
            $newFile->parentId = $request->request->get('parentId');
            $newFile->title = $originalName;
            $newFile->description = '';
            $newFile->fileName = $originalName;
            $newFile->save();

            require_once CMS . '/vendor/blueimp/jquery-file-upload/server/php/UploadHandler.php';
            $uploader = new \UploadHandler(array(
                'upload_dir' => dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/',
                'image_versions' => array()
            ), false);
            $_SERVER['HTTP_CONTENT_DISPOSITION'] = $newFile->id;
            $result = $uploader->post(false);

            $newFile->fileLocation = $newFile->id . '.' . $ext;
            $newFile->fileExtension = $ext;
            $newFile->fileType = $result['files'][0]->type;
            $newFile->fileSize = $result['files'][0]->size;
            $newFile->save();

            if (file_exists(dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $result['files'][0]->name)) {
                rename(dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $result['files'][0]->name, dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $newFile->id . '.' . $ext);
            }

            return new Response(json_encode($newFile));
        }
        return new Response(json_encode(array(
            'failed'
        )));
    }

    public function image(Application $app, Request $request, $imageAsset, $imageSize = null)
    {
        $asset = \Site\DAOs\Asset::findById($app['em'], $imageAsset);
        if (!$asset) {
            $asset = \Site\DAOs\Asset::findByField($app['em'], 'title', $imageAsset);
            if (!$asset) {
                $app->abort(404);
            }
        }
        $fileType = $asset->fileType;
        $fileName = $asset->fileName;
        $file = dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $asset->fileLocation;
        if ($imageSize) {
            if ((file_exists($file) && getimagesize($file)) || ('application/pdf' == $fileType)) {
                $size = \Site\DAOs\ImageSize::findById($app['em'], $imageSize);
                if (!$size) {
                    $size = \Site\DAOs\ImageSize::findByField($app['em'], 'title', $imageSize);
                    if (!$size) {
                        $app->abort(404);
                    }
                }

                $cache = dirname($_SERVER['SCRIPT_FILENAME']) . '/../cache/image/';
                if (!file_exists($cache)) {
                    mkdir($cache, 0777, true);
                }
                $thumbnail = $cache . md5($asset->id . '-' . $size->id . '-' . $size->width) . (('application/pdf' == $fileType) ? '.jpg' : '.' . $asset->fileExtension);
                if (!file_exists($thumbnail)) {
                    if ('application/pdf' == $fileType) {
                        $image = new imagick($file . '[0]');
                        $image->setImageFormat('jpg');
                        $image->setColorspace(imagick::COLORSPACE_RGB);
                        $image->thumbnailImage($size->width, null);
                        $image->writeImage($thumbnail);
                    } else {
                        $image = new Imagick($file);
                        $image->adaptiveResizeImage($size->width, 0);
                        $image->writeImage($thumbnail);
                    }
                }
                $file = $thumbnail;
            }
        }

        if (!file_exists($file) || !getimagesize($file)) {
            $file = __DIR__ . '/images/noimage.jpg';
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

    public function download(Application $app, $imageAsset)
    {
        $asset = \Site\DAOs\Asset::findById($app['em'], $imageAsset);
        if (!$asset) {
            $asset = \Site\DAOs\Asset::findByField($app['em'], 'title', $imageAsset);
            if (!$asset) {
                $app->abort(404);
            }
        }
        $fileType = $asset->fileType;
        $fileName = $asset->fileName;
        $file = dirname($_SERVER['SCRIPT_FILENAME']) . '/../uploads/' . $asset->fileLocation;
        if (!file_exists($file)) {
            $app->abort(404);
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