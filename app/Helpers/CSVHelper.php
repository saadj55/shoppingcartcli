<?php

namespace App\Helpers;
class CSVHelper{

    public static function readCSV($path, $delimiter = ","){

        if(!file_exists($path) || !is_readable($path))
            return FALSE;

        $header = NULL;
        $data = array();
        if (($handle = fopen($path, 'r')) !== FALSE)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;

    }
}
