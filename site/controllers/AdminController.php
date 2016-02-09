<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use models\ArticleModel;
use models\CategoryModel;
use models\FlatMenuModel;
use models\MenuModel;
use models\ResourceModel;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Description of IndexController
 *
 * @author Tibi
 */
class AdminController {

    public function indexAction(Request $request, Application $app) {
        $params = array('password' => null, 'encodedPassword' => null);

        if (( $password = $request->getSession()->get('password', null))) {
            $params['password'] = $password;
            $encoder = new MessageDigestPasswordEncoder();
            $params['encodedPassword'] = $encoder->encodePassword($password, '');
            $request->getSession()->remove('password');
        }

        return $app['twig']->render('admin/dashboard.twig', $params);
    }

    public function encodePasswordAction(Request $request, Application $app) {
        $request->getSession()->set('password', $request->get('password'));
        return $app->redirect('/admin/');
    }

    public function articlesAction(Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $res = $pdo->query("select a.* from articles a ");
        $rows = array();
        foreach ($res as $row) {
            $rows[] = new ArticleModel($pdo, $row);
        }


        return $app['twig']->render('admin/articles.twig', array(
                    'jsFiles' => array('/js/admin.js'),
                    'articles' => $rows
        ));
    }

    public function articleAction($articleId, Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        if ($articleId && $articleId != 'new') {
            $article = ArticleModel::getById($pdo, $articleId);
        } else {
            $article = new ArticleModel();
        }
        return $app['twig']->render('admin/article_edit.twig', array(
                    'jsFiles' => array('/js/tinymce/tinymce.min.js'),
                    'article' => $article,
                    'categories' => CategoryModel::getCategories($pdo)
        ));
    }

    public function saveArticleAction(Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $article = ArticleModel::createFromData($pdo, $request->request->get('article'));
        $article->save();
        return $app->redirect('/admin/article/' . $article->id);
    }

    public function editMenuAction($menuId, Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $menu = FlatMenuModel::getById($pdo, $menuId);
        /* $res = $pdo->query("select a.* from articles a join articles_categories i on a.id = i.article_id where i.category_id = 1 ");
          $articles = array();
          foreach ($res as $row) {
          $articles[] = new ArticleModel($pdo, $row);
          } */

        return $app['twig']->render('admin/menu_edit.twig', array(
                    'jsFiles' => array('/js/jstree/jstree.js', '/js/jstree/jstree.dnd.js'),
                    'cssFiles' => array('/js/jstree/themes/default/style.css'),
                    'menuData' => $menu->toJson(),
                    'menuId' => $menuId,
                    'articles' => $articles
        ));
    }

    public function menuSaveAction($menuId, Request $request, Application $app) {

        $data = $request->get('data');

        $pdo = $app['db.pdo'];

        $stmt = $pdo->prepare("replace into menu_items "
                . " (id , title, slug, article_id, parent, sort_index, menu_id)"
                . " values(:id , :title, :slug, :article_id, :parent, :sort_index, :menu_id ) ");


        foreach ($data as $ix => $row) {
            $params = array('menu_id' => $menuId,
                'sort_index' => $ix,
                'title' => $row['text'],
                'slug' => $row['data']['slug'],
                'article_id' => $row['data']['article_id'],
                'parent' => $row['parent'],
                'id' => $row['id']
            );

            if (!$stmt->execute($params)) {
                return "false";
            }
        }

        return "ok";
    }

    public function imagesAction() {
        return '';
    }

    public function uploadImageAction(Request $request, Application $app) {
        $files = $request->files->get('userfile');
        /* Make sure that Upload Directory is properly configured and writable */
        $mediaDir = '/img/media/';
        $path = __DIR__ . '/../web' . $mediaDir;


        $filename = md5($files->getClientOriginalName() . time()) . "." . $files->getClientOriginalExtension();
        $files->move($path, $filename);
        $returnObj = array(
            'file_name' => $mediaDir . $filename,
            'title' => $request->get('title'),
            'width' => $request->get('width'),
            'height' => $request->get('height')
        );

        return ' <script language="javascript" type="text/javascript">
                window.parent.window.jbImagesDialog.uploadFinish(' . json_encode($returnObj) . ' );
            </script>';
    }

    public function updateArticleAction($articleId, $action, Request $request, Application $app) {
        switch ($action) {
            case 'add_to_menu':
                $menuId = 1;
                return $this->addArticleToMenu($articleId, $menuId, $app);
                break;
        }
    }

    protected function addArticleToMenu($articleId, $menuId, Application $app) {
        $pdo = $app['db.pdo'];
        $article = ArticleModel::getById($pdo, $articleId);
        $stmt = $pdo->prepare("insert into menu_items (title, slug, article_id menu_id, sort_index) values( :title, :slug,:article_id, :menu_id, :sort_index ) ");
        $nextSortIndex = $pdo->query("select count(id) as sort_index from menu_items where menu_id = $menuId ")->fetch();
        $res = $stmt->execute(array(
            'title' => $article->title,
            'slug' => $article->slug,
            'article_id' => $article->id,
            'menu_id' => $menuId,
            'sort_index' => $nextSortIndex['sort_index']
        ));

        return $app->redirect('/admin/menu/' . $menuId);
    }

    public function uploadResourceAction(Request $request, Application $app) {
        $file = $request->files->get('userfile');
        $mediaDir = '/resources/';
        $path = __DIR__ . '/../web' . $mediaDir;
        $filename = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();

        $file->move($path, $filename);
        return array($file, $filename, filesize($path . $filename));
    }

    public function resourcesAction(Request $request, Application $app) {
        $pdo = $app['db.pdo'];

        $res = $pdo->query("select * from resources  ");
        $rows = array();
        while (($row = $res->fetchObject('\models\ResourceModel'))) {
            $rows[] = $row;
        }

        return $app['twig']->render('admin/resources.twig', array(
                    'jsFiles' => array('/js/admin.js'),
                    'resources' => $rows
        ));
    }

    public function resourceAction($resourceId, Request $request, Application $app) {
        if ($resourceId) {
            $pdo = $app['db.pdo'];
            $stmt = $pdo->prepare("select * from resources where id = :id ");
            $stmt->execute(array('id' => $resourceId));
            $resource = $stmt->fetchObject('\models\ResourceModel');
        } else {
            $resource = new ResourceModel();
        }

        return $app['twig']->render('admin/resource_edit.twig', array(
                    'jsFiles' => array('/js/admin.js'),
                    'resource' => $resource
        ));
    }

    public function deleteResourceAction($resourceId, Request $request, Application $app) {
        $pdo = $app['db.pdo'];

        $pdo->exec("delete from resources where id = $resourceId ");
        if ($request->isXmlHttpRequest()) {
            return 'ok';
        }
        return $app->redirect('/admin/resources');
    }

    public function saveResourceAction($resourceId, Request $request, Application $app) {
        $pdo = $app['db.pdo'];

        $params = $request->request->get('resource');

        $sqlString = " resources set ";

        if (!empty($request->files)) {


            $fileData = $this->uploadResourceAction($request, $app);
            $file = $fileData[0];
            $name = $fileData[1];
            $size = $fileData[2];
            $params['file_name'] = $name;
            $params['file_type'] = $file->getClientOriginalExtension();
            $params['file_size'] = $size;
        }
        $keys = array_keys($params);
        $sqlString .= implode(' , ', array_map(function($key) {
                    return "{$key} = :{$key}";
                }, $keys));

        if ($resourceId) {
            $params['id'] = $resourceId;
            $sqlString = 'UPDATE ' . $sqlString . ' where id = :id ';
        } else {
            $sqlString = 'INSERT into ' . $sqlString;
        }


        $stmt = $pdo->prepare($sqlString);
        $res = $stmt->execute($params);

        return $app->redirect('/admin/resources');
    }

}
