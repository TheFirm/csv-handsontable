<?php
/**
 * Created by PhpStorm.
 * User: boom
 * Date: 15.09.14
 * Time: 18:01
 */
namespace Helpers;

interface FileReader {

    /**
     * Read file
     * @param string $file_name
     * @return mixed
     */
    public function read($file_name);

} 