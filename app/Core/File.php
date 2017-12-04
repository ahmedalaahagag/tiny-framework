<?php

namespace App\Core;

/**
 * Class File
 * File class handles I/O
 * @package App\Core
 */
class File
{
    /**
     * File constructor.
     */
    function __construct()
    {
    }

    /**
     * reads a file from path
     * @param $path
     * @return bool|string
     */
    function getFileContents($path)
    {
        //TODO:I/O Related operations should be handled like symfony file component
        //http://api.symfony.com/3.3/Symfony/Component/HttpFoundation/File/File.html
        try {
            $fh = fopen($path, "rb");
            $data = fread($fh, filesize($path));
            fclose($fh);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $data;
    }


    /**
     * write a file from path
     * @param $path
     * @param $data
     * @return bool|string
     */
    function getWriteContents($path, $data)
    {
        //TODO:I/O Related operations should be handled like symfony file component
        //http://api.symfony.com/3.3/Symfony/Component/HttpFoundation/File/File.html
        try {
            $data = file_put_contents($path, $data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}