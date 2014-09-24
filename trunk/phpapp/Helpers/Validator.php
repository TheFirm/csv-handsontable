<?php

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
        //$data_from_file = json_decode($data_to_validate);
        $data_from_file = $data_to_validate;
        $this->transformTitlesFromFileToLowerCase($data_from_file);
        $this->load_config();
    }

    function transformTitlesFromFileToLowerCase($data_from_file){
        $this->data_to_validate[0] = /*array_map('strtolower',*/ $data_from_file[0]/*)*/;
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
            $result[] = /*strtolower*/($title);
        }
        return $result;
    }

    protected function validateColumns()
    {
        $result = array('success' => true, 'errors' => array());
        $errors = array();

        $columns_title = $this->data_to_validate[0];
        foreach ($this->config as $conf_title => $conf) {
            $name_mismatch = true;
            $in_file_to_much = false;
            $in_file_to_few = false;

            $column_conf = $this->getColumnsArrayFromConfig($conf);
            $res = array_intersect($column_conf, $columns_title);

            if ((count($res) == count($column_conf))&&(count($res) == count($columns_title))) {
                return array(
                    'success' => true,
                    'errors' => array(),
                    'result' => $conf_title
                );
            }
            if (count($res) == count($column_conf)) {
                $in_file_to_much = true;
            }
            if (count($res) == count($columns_title)) {
                $in_file_to_few = true;
            }

            $column_errors_from_file = array_diff($columns_title,$res);
            $column_errors_from_conf = array_diff($column_conf,$res);

            $errors[$conf_title] = array(
                "name_mismatch"=>$name_mismatch,
                "in_file_to_much"=>$in_file_to_much,
                "in_file_to_few"=>$in_file_to_few,
                "from_file"=>array_values($column_errors_from_file),
                "from_conf"=>array_values($column_errors_from_conf)
            );
        }

        $result['success'] = false;
        $result['errors'] = [
            'types' => $errors,
            'bestMatch' => self::findBestMatchingConfig($errors),
        ];
        return $result;
    }

    protected static function findBestMatchingConfig($column_errors){
        $mostMatchingConfigName = false;
        $mostMatchingConfigErrors = [];

        foreach ($column_errors as $config_name => $col_errs) {
            if(empty($mostMatchingConfig) or count($col_errs) < count($mostMatchingConfigErrors)){
                $mostMatchingConfigName = $config_name;
                $mostMatchingConfigErrors = $col_errs;
            }
        }

        return [$mostMatchingConfigName => $mostMatchingConfigErrors];
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
        return $this->result['success'];
    }

    public function getResult(){
        return $this->result;
    }
} 