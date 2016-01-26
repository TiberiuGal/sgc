<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use models\ArticleModel;
use models\CategoryModel;
use models\MenuModel;

/**
 * Description of IndexController
 *
 * @author Tibi
 */
class AdminController {

    public function indexAction(Request $request) {
        $request->redirect('/admin/articole');
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

    public function editArticleAction($articleId, Request $request, Application $app) {
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
        return $app->redirect('/admin/edit-article/' . $article->id);
    }

    public function editMenuAction($menuId, Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $menu = MenuModel::getById($pdo, $menuId);
        return $app['twig']->render('admin/menu_edit.twig', array(
                    'jsFiles' => array('/js/jstree/jstree.js', '/js/jstree/jstree.dnd.js'),
                    'cssFiles' => array('/js/jstree/themes/default/style.css'),
                    'menu' => $menu,
                    'nextId' => $menu->getNextId()
        ));
    }
    
    public function editMenu2Action(Request $request, Application $app) {
        $pdo = $app['db.pdo'];
        $data = $pdo->query("select key_value from site_configs where key_name='main_menu'")->fetch();
        
        return $app['twig']->render('admin/menu_edit2.twig', array(
                    'jsFiles' => array('/js/jstree/jstree.js', '/js/jstree/jstree.dnd.js'),
                    'cssFiles' => array('/js/jstree/themes/default/style.css'),
                    'data' => json_decode($data['key_value']),
                    
        ));
    }
    public function menuSaveAction(Request $request, Application $app) {
        
        $j = json_encode($request->get('data'));
        $pdo = $app['db.pdo'];
        $st = $pdo->prepare(" update site_configs set key_value = :val where key_name = :key ");
        $st->execute(array('val'=>$j, 'key'=>'main_menu'));
        return "ok";
    }

}
