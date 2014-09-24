<?php

namespace Helpers;

interface FileReader {

    /**
     * Read file
     * @param string $file_name
     * @return mixed
     */
    public function read($file_name);

} 