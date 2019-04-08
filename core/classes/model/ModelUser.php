<?php

namespace Core\Model;

Class ModelUser {

    protected $table_name;
    /** @var \Core\FileDB */
    protected $db;

    public function __construct(\Core\FileDB $db, $table_name) {
        $this->table_name = $table_name;
        $this->db = $db;
    }

    public function load($id) {
        $data_row = $this->db->getRow($this->table_name, $id);
        if ($data_row) {
            return new \Core\User\User($data_row);
        }
    }

    public function insert($id, \Core\User\User $user) {
        if (!$this->db->rowExists($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $user->getData());
            $this->db->save();
            
            return true;
        }
    }

    public function update($id, \Core\User\User $user) {
        if ($this->db->rowExists($this->table_name, $id)) {
            $this->db->setRow($this->table_name, $id, $user->getData());
            $this->db->save();
            
            return true;
        }
    }

    public function delete($id) {
        if ($this->db->rowExists($this->table_name, $id)) {
            $this->db->deleteRow($this->table_name, $id);
            $this->db->save();
            
            return true;
        }
    }

    public function loadAll() {
        $user_masyvas = [];
        foreach ($this->db->getRows($this->table_name) as $user) {
            $user_masyvas[] = new \Core\User\User($user);
        }
        
        return $user_masyvas;
    }

    public function deleteAll() {
        if ($this->db->deleteRows($this->table_name)) {
            $this->db->save();
            return true;
        }
    }

    public function getCount() {
        $get_count = $this->db->getCount($this->table_name);     
        if ($get_count) {
            return $get_count;
        }
        
        return 0;
    }

}