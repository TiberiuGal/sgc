<?php

namespace controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use models\ArticleModel;
use models\CategoryModel;

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

}
