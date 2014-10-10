<?php
/**
 * Created by PhpStorm.
 * User: oops
 * Date: 10/9/2014
 * Time: 6:11 PM
 */

namespace Helpers;


class Transformer {

    public static function transformRowsOut(&$rows){
        foreach ($rows as &$row) {
            foreach ($row as &$cell) {
                $cell = ["value" => $cell];
            }
        }
        return $rows;
    }

    public static function transformColsOut(&$columns){
        foreach ($columns as &$col) {
            $col = ["name" => $col];
        }
        return $columns;
    }

    public static function transformRowsIn(&$rows){
        foreach ($rows as &$row) {
            foreach ($row as &$cell) {
                $cell = $cell["value"];
            }
        }
        return $rows;
    }

    public static function transformColsIn(&$columns){
        foreach ($columns as &$col) {
            $col = $col["name"];
        }
        return $columns;
    }
} 