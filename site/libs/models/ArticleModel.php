<?php

namespace models;

class ArticleModel {

    use ModelTrait;
    protected $data;
    protected $pdo;
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

    public static function getById($pdo, $id) {
        $row = $pdo->query(" select a.* from articles a where id = $id");
        return new ArticleModel($pdo, $row->fetch($pdo::FETCH_ASSOC));
    }

    public static function getBySlug($pdo, $slug) {

        $stmt = $pdo->prepare(" select a.* from articles a where slug = :slug");
        $stmt->execute(array('slug' => $slug));
        if (!$stmt->rowCount()) {
            throw new \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException($slug);
        }
        return new ArticleModel($pdo, $stmt->fetch($pdo::FETCH_ASSOC));
    }

    public static function createFromData($pdo, $data) {

        $obj = new ArticleModel($pdo);

        $obj->load($data);
        return $obj;
    }

    protected function load($data) {
        $this->data = $data;
        foreach ($this->data as $key => $val) {
            $this->$key = $val;
        }
    }

    public function __construct($pdo = null, $data = null) {
        $this->pdo = $pdo;
        if (empty($data)) {
            return;
        }
        $this->load($data);
        $this->_setCategories();
    }

    function __get($name) {

        if (method_exists($this, ( $fn = "get{$name}"))) {
            return $this->$fn();
        }
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
                excerpt = :excerpt
                where id = :id
                ");
        $stmt->execute(array('title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => $this->author,
            'excerpt' => $this->excerpt,
            'id' => $this->id
        ));
        $this->updateCategories();
    }

    public function saveNew() {
        $stmt = $this->pdo->prepare(" insert into articles set 
                title = :title,
                slug = :slug,
                body = :body,
                author = :author,
                excerpt = :excerpt
                ");
        $stmt->execute(array('title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => $this->author,
            'excerpt' => $this->excerpt
        ));


        $this->id = $this->pdo->lastInsertId();
        $this->updateCategories();
    }

    protected function updateCategories() {
        var_dump($this);
        $stmt = $this->pdo->prepare("delete from articles_categories where article_id = :id ");
        $stmt->execute(array('id' => $this->id));
        $insertStmt = $this->pdo->prepare("insert into articles_categories (article_id, category_id) values(:article_id, :category_id) ");
        foreach ($this->categories as $key => $val) {
            $insertStmt->execute(array('article_id' => $this->id, 'category_id' => $key));
        }
    }

}
