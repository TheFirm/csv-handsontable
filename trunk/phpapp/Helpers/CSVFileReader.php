<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 18:29
 */

namespace Helpers;
use Helpers;

class CSVFileReader implements FileReader {

    protected $json_data;

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
        $this->json_data = json_encode($result);
    }

    /**
     * @return mixed
     */
    public function validation(){
        $validator = new Validator($this->json_data);
        return $validator->validate();
    }

} 