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
    //relative path to json config file
    const CONFIG_FILE = '/../config/validator.json';

    //config array
    protected $config;
    //array data to validate
    protected $data_to_validate;

    protected $result;


    /**
     * @param $data_to_validate array data loaded from file
     */
    function __construct($data_to_validate)
    {
        $data_from_file = json_decode($data_to_validate);
        $this->transformTitlesFromFileToLowerCase($data_from_file);
        $this->load_config();
    }

    function transformTitlesFromFileToLowerCase($data_from_file){
        $this->data_to_validate[0] = array_map('strtolower', $data_from_file[0]);
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

    static function getColumnsArrayFromConfig($col)
    {
        $result = array();
        foreach ($col as $title =>$column) {
            $result[] = $title;
        }
        return $result;
    }

    protected function validateColumns()
    {
        $result = array('success' => true, 'errors' => array());
        $errors = array();
        $columns_title = $this->data_to_validate[0];
        foreach ($this->config as $conf_title => $conf) {
            $column_conf = $this->getColumnsArrayFromConfig($conf);
            if (count($column_conf) != count($columns_title)) {
                continue;
            }
            $res = array_intersect($column_conf, $columns_title);
            if (count($res) == count($column_conf)) {
                return array('success' => true, 'errors' => array(), 'result' => $conf_title);
            }
            $column_errors = array_diff($columns_title, $res);
            $errors[$conf_title] = $column_errors;
        }

        $result['success'] = false;
        $result['errors'] = $errors;
        return $result;
    }

    protected function findBestMatchingConfig($column_errors){
        $mostMatchingConfigName = false;
        $mostMatchingConfigErrors = [];

        foreach ($column_errors as $config_name => $col_errs) {
            if(empty($mostMatchingConfig) or count($col_errs) < count($mostMatchingConfigErrors)){
                $mostMatchingConfigName = $config_name;
                $mostMatchingConfigErrors = $col_errs;
            }
        }

        return [$mostMatchingConfigName => $column_errors];
    }

    protected function findCellsError()
    {
        return array('success' => true);
    }

    public function validate()
    {
        $this->result = $this->validateColumns();
        if ($this->result['success']) {
            $this->result = array_merge($this->result, $this->findCellsError());
        }
        var_dump($this->result);
        return $this->result['success'];
    }
} 