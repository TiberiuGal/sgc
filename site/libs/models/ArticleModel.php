<?php

namespace models;

class ArticleModel {

    use ModelTrait;

   
    public $id = 0;
    public $title;
    public $slug;
    public $author;
    public $body;
    public $excerpt;
    public $created_at;
    public $categories;
    public $published;
    public $publish_date;

    public function publishDate($format = 'd M') {
        $d = new \DateTime($this->publish_date);
        return $d->format($format);
    }

    public static function getById($pdo, $id) {
        $row = $pdo->query(" select a.* from articles a where id = $id");
        return new ArticleModel($pdo, $row->fetch($pdo::FETCH_ASSOC));
    }

    public function getBySlugOrNotFound($slug) {
        try {
            $article = $this->getBySlug($slug);
        } catch (\Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException $ex) {
            $article = $this->getBySlug('/404');
        }
        return $article;
    }

    public function getBySlug($slug) {
        if (strpos($slug, '/') !== 0) {
            $slug = '/' . $slug;
        }
        $stmt = $this->pdo->prepare(" select a.* from articles a where slug = :slug");
        $stmt->execute(array('slug' => $slug));
        if (!$stmt->rowCount()) {
            throw new \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException($slug);
        }
        return new ArticleModel($this->pdo, $stmt->fetch(\PDO::FETCH_ASSOC));
    }

    public static function createFromData($pdo, $data) {
        $obj = new ArticleModel($pdo);
        $obj->load($data);
        return $obj;
    }
    
    public function remove($articleId){
        $this->pdo->exec("delete from articles where id=$articleId");
        
    }

    public function __construct($pdo = null, $data = null) {
        $this->pdo = $pdo;
        if (empty($data)) {
            return;
        }
        $this->load($data);
        $this->_setCategories();
    }

    public function hasCategory($categoryId) {
        return array_key_exists($categoryId, $this->categories);
    }

    protected function _setCategories() {

        $this->categories = array();
        foreach ($this->pdo->query("select title, id from categories c join articles_categories i on i.category_id = c.id and i.article_id = {$this->id}") as $cat) {
            $this->categories[$cat['id']] = $cat['title'];
        }
    }

    public function save() {
        if ($this->id) {
            $this->update();
        } else {
            $this->saveNew();
        }
    }

    public function update() {
        $stmt = $this->pdo->prepare(" update articles set 
                title = :title,
                slug = :slug,
                body = :body,
                author = :author,
                excerpt = :excerpt, 
                publish_date = :publish_date
                where id = :id
                ");
        $stmt->execute(array('title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => $this->author,
            'excerpt' => $this->excerpt,
            'publish_date' => $this->publish_date,
            'id' => $this->id
        ));
        $this->updateCategories();
        $this->updateMenuItem();
    }

    public function saveNew() {
        $stmt = $this->pdo->prepare(" insert into articles set 
                title = :title,
                slug = :slug,
                body = :body,
                author = :author,
                excerpt = :excerpt, 
                publish_date = :publish_date
                ");
        $stmt->execute(array('title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => $this->author,
            'excerpt' => $this->excerpt,
            'publish_date' => $this->publish_date
        ));


        $this->id = $this->pdo->lastInsertId();
        $this->updateCategories();
    }

    protected function updateCategories() {

        $stmt = $this->pdo->prepare("delete from articles_categories where article_id = :id ");
        $stmt->execute(array('id' => $this->id));
        $insertStmt = $this->pdo->prepare("insert into articles_categories (article_id, category_id) values(:article_id, :category_id) ");
        foreach ($this->categories as $key => $val) {
            $insertStmt->execute(array('article_id' => $this->id, 'category_id' => $key));
        }
    }

    protected function updateMenuItem() {
        $stmt = $this->pdo->prepare("update menu_items set slug = :slug where article_id = :id ");
        $stmt->execute(array('id' => $this->id, 'slug' => $this->slug));
    }

    public function getNews($limit = 2) {

        $stmt = $this->pdo->query("SELECT a.slug, a.title, a.excerpt, a.publish_date "
                . " FROM articles a "
                . " JOIN articles_categories i ON a.id = i.article_id AND i.category_id = 2 "
                . " ORDER BY publish_date DESC "
                . " LIMIT $limit ");


        return $this->getList($stmt);
    }

}
