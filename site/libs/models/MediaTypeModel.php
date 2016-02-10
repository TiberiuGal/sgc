<?php

namespace models;

class MediaTypeModel {

    use ModelTrait;

    public function getMediaTypes() {
        return $this->pdo->query("select id, title from media_types ");
    }

}
