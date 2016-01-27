<?php

namespace models;

use models\MenuModel;

class FlatMenuModel extends MenuModel {

    static protected $flat = true;

    public function parseItems($res) {

        return self::parseFlat($res);
    }

    public static function getById($pdo, $id) {

        $res = $pdo->query(" select a.* from menu a where id = $id");
        return FlatMenuModel::createFromData($pdo, $res->fetch($pdo::FETCH_ASSOC));
    }

    public static function createFromData($pdo, $data) {
        $obj = new FlatMenuModel($pdo);
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

    public static function getItems($pdo, $id = 1) {
        $res = $pdo->query("select * from menu_items where menu_id = $id order by parent, sort_index", \PDO::FETCH_ASSOC);

        $items = self::parseItems($res);
        return $items;
    }

}
