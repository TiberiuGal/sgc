<?php

namespace services;

/**
 * Description of ConfigService
 *
 * @author Tibi
 */
class ConfigService {

    protected $pdo;
    protected $data;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getData() {
        if (!isset($this->data)) {
            $stmt = $this->pdo->query("select key_name, key_value from site_configs");
            $configs = array();
            foreach ($stmt->fetchAll() as $row) {
                $configs[$row['key_name']] = $row['key_value'];
            }
            $this->data = $configs;
        }
        return $this->data;
    }

}
