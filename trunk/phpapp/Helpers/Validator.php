<?php

namespace Helpers;

class Validator
{
    //config array
    protected $config;

    //array data to validate
    protected $columns_to_validate;
    protected $result;

    protected $rows;
    protected $headers;


    /**
     * @param $rows
     * @param $headers
     * @internal param array $data_to_validate data loaded from file
     */
    function __construct($rows, $headers) {
        $this->rows = $rows;
        $this->headers = $headers;
    }

    protected function getConfigs() {
        if ($this->config !== null) {
            return $this->config;
        }

        $this->config = General::readValidatorConfig();
        return $this->config;
    }

    protected function getConfigByName($configName){
        $config = $this->getConfigs();
        if(!array_key_exists($configName, $config)){
            throw new \Exception("Missing config '$configName'");
        }
        return $config[$configName];
    }

    static function getColumnsArrayFromConfig($col) {
        $result = array();
        foreach ($col as $title => $column) {
            $result[] = General::transformConfigHeaderName($title);
        }
        return $result;
    }



    public function validateColumns($configName) {
        $selectedConfig = $this->getConfigByName($configName);
        $configHeaders = $this->getColumnsArrayFromConfig($selectedConfig);

        $intersectedHeaders = array_intersect($this->headers, $configHeaders);
        $notMatchedHeadersInFile = array_diff($this->headers, $intersectedHeaders);
        $missingRequiredHeaders = $this->getRequiredMissingHeaders($selectedConfig, $intersectedHeaders);

        if( count($missingRequiredHeaders) == 0 ){
            return array(
                'success' => true
            );
        }

        $notUsedColumnsFromConfig = array_diff($configHeaders, $intersectedHeaders);
        $notUsedNotRequiredColumnsFromConfig = array_diff($notUsedColumnsFromConfig, $missingRequiredHeaders);

        return array(
            'success' => false,
            'meta' => [
                'allPossibleValues' => $configHeaders
            ],
            'errors' => [
                'notMatchedHeadersInFile' => array_values($notMatchedHeadersInFile),
                'notUsedNotRequiredColumnsFromConfig' => array_values($notUsedNotRequiredColumnsFromConfig),
                'missingRequiredHeaders' => array_values($missingRequiredHeaders),
                'allPossibleValues' => array_values($configHeaders),
            ]
        );
    }

    protected function getRequiredMissingHeaders($config, $headers){
        $requiredNames = [];
        foreach ($config as $colName => $options) {
            if( isset($options['required']) and $options['required'] ){
                $requiredNames[] = General::transformConfigHeaderName($colName);
            }
        }

        $missingRequiredHeaders = array_diff($requiredNames, $headers);
        return $missingRequiredHeaders;
    }
} 