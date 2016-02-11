<?php

namespace models;

use models\MenuModel;

class FlatMenuModel extends MenuModel {

    public function parseItems($res) {
        return $this->parseFlat($res);
    }

}
