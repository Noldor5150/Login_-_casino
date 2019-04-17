<?php

namespace Core\Database;

class SQLBuilder extends Core\Database\Abstracts\SQLBuilder {

    /**
     * Returns $column, but surrounded with backticks
     * 
     * @param string $column column 1
     * @return string `column 1`
     */
    public static function column($column) {
        return "`$column`";
    }

    /**
     * Returns imploded array of backticked columns
     * 
     * @param array $column_array ['column 1', 'column 2', ...]
     * @return string `column 1`, `column 2`, `column 2`
     */
    public static function columns($column_array) {
        foreach ($column_array as &$col) {
            $col = self::column($col);
        }

        return implode(', ', $column_array);
    }

    /**
     * Returns bind placeholder syntax for a column
     * 
     * If column name contains a space, 
     * it replaces it to underscore
     * 
     * @param string $column column 1
     * @return string :column_1
     */
    public static function bind($column) {
        return ':' . str_replace(' ', '_', $column);
    }

    /**
     * Returns an imploded array of column bind placeholders
     * 
     * @param array $column_array ['column 1', 'column 2', ...]
     * @return string :column_1, :column_2, :column_3
     */
    public static function binds($column_array): string {
        foreach ($column_array as &$column) {
            $column = self::bind($column);
        }
        return implode(', ', $column_array);
    }

    /**
     * Returns backticked column name equaled to a bind placeholder
     * 
     * @param string $column column 1
     * @return string `column 1`=:column_1
     */
    public static function columnEqualBind($column): string {
        return self::column($column) . '=' . self::bind($column);
    }

    /**
     * Returns an imploded array of column names
     * equaled to bind placeholders
     * 
     * @param array $column_array ['column 1', 'column 2', ...]
     * @param string $delimiter Can be changed to 'AND', 'OR', etc...
     * @return string `column 1`=:column_1, `column 2`=:column_2,
     */
    public static function columnsEqualBinds($column_array, $delimiter = ', '): string {
        foreach ($column_array as &$column) {
            $column = self::columnEqualBind($column);
        }
        return implode($delimiter, $column_array);
    }

    /**
     * Returns a single quoted value
     * 
     * @param string $value some value
     * @return string 'some value'
     */
    public static function value($value): string {
        return "'$value'";
    }

    /**
     * Returns an imploded array of
     * single quoted values
     * 
     * @param array $value_array ['value 1', 'value 2', ...]
     * @return string 'value 1', 'value 2'
     */
    public static function values($value_array): string {
        return implode(', ', $value_array);
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

