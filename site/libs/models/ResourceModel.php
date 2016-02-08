<?php

namespace models;

class ResourceModel {

    use ModelTrait;
    
    public $id = 0;
    public $title;
    public $description;
    public $file_size;
    public $file_type;
    public $file_name;
    public $created_at;
    public $published;
 
    public function getListing(){
        $stmt = $this->pdo->query("select * from resources");
        return $this->getList($stmt);
    }
}