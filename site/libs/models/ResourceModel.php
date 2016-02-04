<?php

namespace models;

class ResourceModel {

    protected $data;
    protected $pdo;
    
    public $id = 0;
    public $title;
    public $description;
    public $file_size;
    public $file_type;
    public $file_name;
    public $created_at;
    public $published;
 

}