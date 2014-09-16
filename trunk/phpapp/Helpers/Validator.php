<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 19:49
 */

namespace Helpers;


class Validator
{

    const CONFIG_FILE = '/../config/validator.json';

    protected $config;
    protected $data_to_validate;

    protected $result;

    function __construct($data_to_validate)
    {
        $this->data_to_validate = json_decode($data_to_validate);
        $this->load_config();
    }


    private function load_config()
    {
        if ($this->config !== null) {
            return $this->config;
        }

        if (!file_exists(__DIR__ . self::CONFIG_FILE)) {
            die('No validator config file');
        }

        $this->config = json_decode(file_get_contents(__DIR__ . self::CONFIG_FILE), true);
        return $this->config;
    }

    static function column2array($col)
    {
        $result = array();
        foreach ($col as $title =>$column) {
            $result[] = $title;
        }
        return $result;
    }

    protected function findBestMatchingConfig()
    {
        $result = array('success' => true, 'errors' => array());
        $errors = array();
        $columns_title = $this->data_to_validate[0];

        foreach ($this->config as $conf_title => $conf) {
            $column_conf = $this->column2array($conf);
            if (count($column_conf) != count($columns_title)) {
                continue;
            }
            $res = array_intersect($column_conf, $columns_title);
            if (count($res) == count($column_conf)) {
                return array('success' => true, 'errors' => array(), 'result' => $conf_title);
            }
            $column_error = array_diff($columns_title, $res);
            $errors[$conf_title] = $column_error;

        }
        $result['success'] = false;
        $result['errors'] = $errors;
        return $result;
    }

    protected function findCellsError()
    {
        return array('success' => true);
    }

    public function validate()
    {
        $this->result = $this->findBestMatchingConfig();
        if ($this->result['success']) {
            $this->result = array_merge($this->result, $this->findCellsError());
        }
        var_dump($this->result);
        return $this->result['success'];
    }
} 