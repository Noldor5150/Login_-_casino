<?php

namespace Core\Database;

class Model extends Core\Database\Abstracts\Model {
    
      public function create() {

        $SQL_columns = [];

        foreach ($this->fields as $field) {
            $SQL_columns[] = strtr('@col_name @col_type @col_flags', [
                '@col_name' => SQLBuilder::column($field['name']),
                '@col_type' => $field['type'],
                '@col_flags' => isset($field['flags']) ? implode(' ', $field['flags']) : ''
            ]);
        }
        $sql = strtr('CREATE TABLE @table_name (@columns);', [
            '@table_name' => SQLBuilder::table($this->table_name),
            '@columns' => implode(', ', $SQL_columns)
        ]);
        
        try{
        return $this->pdo->exec($sql);
        } catch (PDOException $e){
        throw  new Exception('eik pavalgyt');
        }
    }



    public function insert($row) {
        
    }

    public function insertIfNotExists($row, $unique_columns) {
        
    }

    public function update($row = array(), $conditions = array()) {
        
    }

}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 
