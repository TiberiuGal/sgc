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
    protected $media_types = null;

    public function byId($id) {
        $stmt = $this->pdo->prepare("select * from resources where id = :id ");
        $stmt->execute(array('id' => $id));
        return $this->getItem($stmt);
    }

    public function getListing() {
        $stmt = $this->pdo->query("select * from resources");
        return $this->getList($stmt);
    }

    public function getMediaTypes() {
        if (!isset($this->media_types)) {
            $this->media_types = array();
            $this->pullMediaTypes();
        }
        return $this->media_types;
    }

    protected function pullMediaTypes() {
        if (!isset($this->pdo)) {
            return;
        }
        foreach ($this->pdo->query("select title, id from media_types c join resource_media i on i.media_type_id = c.id and i.resource_id = {$this->id}") as $mt) {
            $this->media_types[$mt['id']] = $mt['title'];
        }
    }

    public function hasMediaType($mediaTypeId) {
        return array_key_exists($mediaTypeId, $this->getMediaTypes());
    }

    public function save($params) {
        $sqlString = " resources set ";
        $mediaTypes = $params['media'];
        unset($params['media']);

        $keys = array_keys($params);
        $sqlString .= implode(' , ', array_map(function($key) {
                    return "{$key} = :{$key}";
                }, $keys));

        if ($params['id']) {
            $sqlString = 'UPDATE ' . $sqlString . ' where id = :id ';
            $id = $params['id'];
        } else {
            unset($params['id']);
            $sqlString = 'INSERT into ' . $sqlString;
        }

        $stmt = $this->pdo->prepare($sqlString);
        $stmt->execute($params);
        if (!isset($id)) {
            $id = $this->pdo->lastInsertId();
            $this->updateMediaTypes($id, $mediaTypes, false);
        } else {
            $this->updateMediaTypes($id, $mediaTypes);
        }
    }

    protected function updateMediaTypes($id, $mediaTypes, $deleteOldMediaTypes = true) {
        if ($deleteOldMediaTypes) {
            $delStmt = $this->pdo->prepare("delete from resource_media where resource_id = :id ");
            $delStmt->execute(array('id' => $id));
        }

        $insertStmt = $this->pdo->prepare("insert into resource_media (resource_id, media_type_id) values(:resource_id, :media_type_id) ");
        foreach (array_keys($mediaTypes) as $key) {
            $insertStmt->execute(array('resource_id' => $id, 'media_type_id' => $key));
        }
    }
    
    public function byMediaType($mediaTypeId){
        $stmt = $this->pdo->query("select r.* from resources r join resource_media i on r.id = i.resource_id and i.media_type_id = $mediaTypeId ");
        return $this->getList($stmt);
    }

}
