<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use models\ArticleModel;
use models\CategoryModel;
use models\FlatMenuModel;
use models\MenuModel;

/**
 * Description of IndexController
 *
 * @author Tibi
 */
class AdminController {

    public function indexAction(Request $request, Application $app) {
        return $app['twig']->render('admin/dashboard.twig', array());
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

    public function editMenu2Action(Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $data = $pdo->query("select key_value from site_configs where key_name='main_menu'")->fetch();
        $jsonData = json_decode($data['key_value']);
        foreach ($jsonData as $key => $val) {
            $jsonData[$key]->data = array("ita" => 2, 'rnd' => rand(3, 10));
        }
        return $app['twig']->render('admin/menu_edit2.twig', array(
                    'jsFiles' => array('/js/jstree/jstree.js', '/js/jstree/jstree.dnd.js'),
                    'cssFiles' => array('/js/jstree/themes/default/style.css'),
                    'data' => $jsonData)
        );
    }

    public function menuSaveAction($menuId, Request $request, Application $app) {

        $data = $request->get('data');

        $pdo = $app['db.pdo'];

        $stmt = $pdo->prepare("replace into menu_items "
                . " (title, link, parent, sort_index, menu_id)"
                . " values(:title, :link, :parent, :sort_index,:menu_id ) "
                . " where id = :id ");


        foreach ($data as $ix => $row) {
            $params = array('menu_id' => $menuId,
                'sort_index' => $ix,
                'title' => $row['text'],
                'link' => $row['data']['slug'],
                'parent' => $row['parent'],
                'id' => $row['id']
            );

            $stmt->execute($params);
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
        $stmt = $pdo->prepare("insert into menu_items (title, link, menu_id, sort_index) values( :title, :link, :menu_id, :sort_index ) ");
        $nextSortIndex = $pdo->query("select count(id) as sort_index from menu_items where menu_id = $menuId ")->fetch();
        $res = $stmt->execute(array(
            'title' => $article->title,
            'link' => $article->slug,
            'menu_id' => $menuId,
            'sort_index' => $nextSortIndex['sort_index']
        ));
        
        return $app->redirect('/admin/menu/' . $menuId);
    }

}
