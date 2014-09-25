<?php

namespace Helpers;

class CSVFileReader implements FileReader
{

    protected $array_data;
    protected $headers = array();
    protected $columns = array();
    protected $rows = array();
    protected $validator;

    function __construct($data, $CSVconvertToJson = true)
    {
        if ($CSVconvertToJson) {
            $this->read($data);
            $this->validation();
        } else {
            $data_arr = json_decode($data, true);
            if ($data_arr != null) {
                asort($data_arr['headers']);

                foreach ($data_arr['headers'] as $head) {
                    $this->headers[] = $head['name'];
                }

                foreach ($data_arr['rows'] as $row) {
                    $_row = array();
                    foreach ($row as $val) {
                        $_row[] = $val['value'];
                    }
                    $this->rows[] = $_row;
                }
                $this->array_data = array($this->headers) + $this->rows;
                foreach ($this->headers as $column) {
                    $this->columns[] = array("data" => $column, "type" => "text");
                }
                $this->validation();
            }
        }
    }

    /**
     * Read CSV file
     * @param string $file_name
     */
    public function read($file_name)
    {
        $file = fopen($file_name, "r");
        $result = array();
        while (!feof($file)) {
            $result[] = fgetcsv($file);
        }
        fclose($file);
        $this->headers = $result[0];
        foreach ($this->headers as $column) {
            $this->columns[] = array("data" => $column, "type" => "text");
        }
        $this->array_data = $result;
        unset($result[0]);

        foreach ($result as $line) {
            if (!$line) {
                continue;
            }
            $this->rows[] = $line;
        }
        sort($this->headers);
    }

    /**
     * @return mixed
     */
    public function validation()
    {
        $this->validator = new Validator($this->array_data);
        return $this->validator->validate();
    }

    public function print_result()
    {
        if ($this->validator) {
            //Send to API
        }
        $result = $this->validator->getResult();
        $result['columns'] = $this->columns;

        foreach ($this->headers as $val) {
            $result['headers'][] = array('name' => $val);
        }

        foreach ($this->rows as $row) {
            $row_array = array();
            foreach ($row as $val) {
                $row_array[] = array('value' => $val);
            }
            $result['rows'][] = $row_array;
        }
        return $result;
    }
}