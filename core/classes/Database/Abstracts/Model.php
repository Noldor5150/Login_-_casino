<?php

namespace Core\Database\Abstracts;

abstract class Model {

    /**
     * Database
     * @var PDO
     */
    protected $pdo;
    protected $fields;
    protected $table_name;

    const NUMBER_SHORT = 'TYNIINT';
    const NUMBER_MED = 'INT';
    const NUMBER_LONG = 'BIGINT';
    const NUMBER_FLOAT = 'FLOAT';
    const NUMBER_DOUBLE = 'DOUBLE';
    const TEXT_SHORT = 'VARCHAR(249)';
    const TEXT_MED = 'MEDIUMTEXT';
    const TEXT_LONG = 'LONGTEXT';

    /**
     * SYMBOL is a single char 
     */
    const CHAR = 'CHAR';

    /**
     * DATETIME is stored in format Y-m-d H:i:s
     */
    const DATETIME = 'DATETIME DEFAULT';
    const DATE_AUTO_ON_CREATE = 'DATETIME DEFAULT CURRENT_TIMESTAMP';
    const DATE_AUTO_ON_UPDATE = 'DATETIME DEFAULT CURRENT_TIMESTAMP' 
            . 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';

    /**
     * TIMESTAMP values are converted from the current time zone to UTC for storage, and converted back from UTC to the current time zone for retrieval. 
     * Careful for 2038!
     */
    const TIMESTAMP = 'TIMESTAMP';
    const TIMESTAMP_AUTO_ON_CREATE = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
    const TIMESTAMP_AUTO_ON_UPDATE = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP '
            . 'CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';

    /**
     * Flags for each table column
     */
    const FLAG_PRIMARY = 'PRIMARY KEY';
    const FLAG_AUTO_INCREMENT = 'AUTO_INCREMENT';
    const FLAG_NOT_NULL = 'NOT NULL';

    public function __construct(\Core\Database\Connection $conn, $table_name, $fields) {
        $this->table_name = $table_name;
        $this->pdo = $conn->getPDO();
        $this->fields = $fields;

        $this->init();
    }

    public function init() {
        $results = $this->pdo->query('SHOW TABLES LIKE ' . SQLBuilder::table($this->table_name));
        if ($results->rowCount() == 0) {
            $this->create();
        }
    }

    /**
     * Creates table table from array
     * 
     * Builds SQL to create table from the array given.
     * 
     * $table = [
     *              [
     *                  'name' => 'my_column',
     *                  'type' => Model::TEXT_SHORT,
     *                  'flags' => [Model::FLAG_NOT_NULL]
     *              ],
     *              [
     *                  'name' => 'my_other_column',
     *                  'type' => Model::NUMBER_SHORT,
     *                  'flags' => [FLAG_NOT_NULL, FLAG_AUTO_INCREMENT]
     *              ],
     *           ];
     * 
     * @throws Exception
     */
    abstract public function create();

    /**
     * Inserts $row (array of values) into the table
     * 
     * Array index represents column name.
     * Array value represents that column value.
     * 
     * $row = [
     *          'column_1' => 'Shake dat ass',
     *          'column_2' => 3,
     *        ];
     * 
     * Returns last insert id or throws exception
     * return $this->pdo->lastInsertId();
     * 
     * @throws Exception
     */
    abstract public function insert($row);

    /**
     * Inserts $row (array of values) into the table
     * if row does not exist already
     * 
     * @param $row array Row to insert
     * @param $unique_columns array of indexes of unique columns 
     * @throws Exception
     */
    abstract public function insertIfNotExists($row, $unique_columns);

    /**
     * Load from table
     * 
     * @param type $conditions
     * @param type $order_by
     * @param type $offset
     * @param type $limit
     * @return type
     */
    public function load($conditions = [], $order_by = [], $offset = 0, $limit = 0) {
        $sql = [];

        if ($conditions) {
            $sql['where'] = 'WHERE ' . SQLBuilder::columnsEqualBinds(array_keys($conditions), 'AND ');
        }

        if ($order_by) {
            $sql['order_by'] = 'ORDER BY ';

            foreach ($order_by as $column => $direction) {
                $sql['order_by'][] = SQLBuilder::column($column) . ' ' . $direction;
            }
        }

        if ($offset) {
            $sql['offset'] = 'OFFSET ' . $offset;
        }

        if ($limit) {
            $sql['limit'] = 'LIMIT ' . $limit;
        }

        $sql['exec'] = strtr('SELECT * FROM @table @where @order_by @offset @limit;', [
            '@table' => $this->table_name,
            '@where' => $sql['where'] ?? '',
            '@order_by' => $sql['order_by'] ?? '',
            '@offset' => $sql['offset'] ?? '',
            '@limit' => $sql['limit'] ?? ''
        ]);

        $query = $this->pdo->prepare($sql['exec']);

        foreach ($conditions as $column => $value) {
            $query->bindValue(SQLBuilder::bind($column), $value);
        }

        Debug::add($sql, Debug::TYPE_SQL, Debug::LEVEL_INFO);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates $row columns based on conditions
     * 
     * Array index represents column name.
     * Array value represents that column (updated) value.
     * 
     * $row = [
     *          'full_name' => 'Wicked Mthfucka',
     *          'photo' => 'https://i.ytimg.com/vi/uVxSZnJv2gs/maxresdefault.jpg,
     *        ];
     * 
     * $conditions = [
     *          'email' => 'lolz@gmail.com          
     *          ];
     * 
     * Conditions represent WHERE statements, combined with AND
     * 
     * @param $row array Row array
     * @param $conditions array WHERE conditions
     * @throws Exception
     */
    abstract public function update($row = [], $conditions = []);
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

