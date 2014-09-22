<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 18:29
 */

namespace Helpers;

class CSVFileReader implements FileReader {

    protected $array_data;
    protected $headers = array();
    protected $columns = array();
    protected $data = array();
    protected $validator;

    function __construct($data,$CSVconvertToJson=true)
    {
        if($CSVconvertToJson){
            $this->read($data);
            $this->validation();
        }else{
            $data_arr = json_decode($data, true);
            if($data_arr!=null){
                $this->headers = sort($data_arr['headers']);
                foreach($data_arr['data'] as $k=>$v){
                    $this->data[$k] = array_values($v);
                }

                $this->array_data = array($this->headers) + $this->data;

                foreach($this->headers as $column){
                    $this->columns[] = array("data"=>$column,"type"=>"text");
                }
                $this->validation();
            }
        }
    }

    /**
     * Read CSV file
     * @param string $file_name
     */
    public function read($file_name){
        $file = fopen($file_name,"r");
        $result = array();
        while(! feof($file))
        {
            $result[]=fgetcsv($file);
        }
        fclose($file);
        $this->headers = $result[0];
        foreach($this->headers as $column){
            $this->columns[] = array("data"=>$column,"type"=>"text");
        }
        $this->array_data = $result;
        unset($result[0]);
        $line_result = array();
        foreach($result as $line){
            $i=0;
            foreach($this->headers as $hcol){
                $line_result[$hcol] = $line[$i];
                $i++;
            }
            $this->data[] = $line_result;
        }
        sort($this->headers);
    }

    /**
     * @return mixed
     */
    public function validation(){
        $this->validator = new Validator($this->array_data);
        return $this->validator->validate();
    }

    public function print_result(){
        if($this->validator){
            //Send to API
        }
        $result = $this->validator->getResult();
        $result['columns'] = $this->columns;
        $result['headers'] = $this->headers;
        $result['data'] = $this->data;
        return $result;
    }
} 