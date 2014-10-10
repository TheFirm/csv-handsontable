<?php

namespace Helpers;

/**
 * Class CSVFileReader
 * @package Helpers
 * @property Validator $validator
 */
class CSVFileReader implements FileReader
{

    protected $tempData;
    protected $headers = array();
    protected $rows = array();
    protected $validator;

    function __construct($filePath)
    {
        $this->read($filePath);
        $this->processRawData();
        return;
    }

    /**
     * Read CSV file
     * @param string $file_name
     * @return mixed|void
     */
    public function read($file_name)
    {
        $file = fopen($file_name, "r");
        $this->tempData = array();
        while (!feof($file)) {
            $this->tempData[] = fgetcsv($file);
        }
        fclose($file);
    }

    protected function processRawData(){
        $this->headers = $this->tempData[0];
        unset($this->tempData[0]);

        foreach ($this->tempData as $line) {
            if (!$line) {
                continue;
            }
            $this->rows[] = $line;
        }
    }

    /**
     * @return array
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * Return array of cell arrays
     * @return array
     */
    public function getRows(){
        return $this->rows;
    }
}