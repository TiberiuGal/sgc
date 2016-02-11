<?php

namespace models;

class MenuModel {

    use ModelTrait;

    public $id;
    public $title;
    public $items;
    static protected $flat = false;

    public function byId($id) {
        $stmt = $this->pdo->prepare("select * from menu where id = :id ");
        $stmt->execute(array('id' => $id));
        return $this->getItem($stmt);
    }

    public static function createFromData($pdo, $data) {

        $obj = new MenuModel($pdo);
        $obj->load($data);
        return $obj;
    }

    protected function load($data) {
        $this->data = $data;
        foreach ($this->data as $key => $val) {
            $this->$key = $val;
        }
        $this->items = self::getItems($this->pdo, $this->id);
    }

    public function toJson() {
        $collector = array();
        foreach ($this->items as $item) {
            $collector[] = array(
                'id' => $item['id'],
                'text' => $item['title'],
                'parent' => $item['parent'] ? $item['parent'] : '#',
                'data' => array(
                    'slug' => $item['slug'],
                    'article_id' => $item['article_id']
                )
            );
        }
        return json_encode($collector);
    }

    public function getItems() {
        if (!isset($this->items)) {
            $this->pullItems();
        }

        return $this->items;
    }

    protected function pullItems() {
        $res = $this->pdo->query("select * from menu_items where menu_id = {$this->id} order by parent, sort_index", \PDO::FETCH_ASSOC);        
        $this->items = $this->parseItems($res);
    }

    public function parseItems($res) {
        return $this->parseTree($res);
    }

    public function parseTree($res) {
        $items = array();
        foreach ($res as $row) {
            if ($row['parent']) {
                $p = $row['parent'];
                if (!isset($items[$p]['items'])) {
                    $items[$p]['items'] = array();
                }
                $items[$p]['items'][$row['id']] = $row;
            } else {
                $items[$row['id']] = $row;
            }
        }
        
        return $items;
    }

    public function parseFlat($res) {
        $items = array();
        foreach ($res as $row) {
            $items[$row['id']] = $row;
        }
        return $items;
    }

    public function getNextId() {
        $res = $this->pdo->query("select max(id) +1 as cnt from menu_items")->fetch();
        return $res['cnt'];
    }

}
