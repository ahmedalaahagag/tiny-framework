<?php
/**
 * helper function file!
 */
//TODO: find a way to make it a class or trait

/**
 * easier to debug using dd
 * @param $args
 */
function dd($args)
{
    var_dump($args);
    exit;
}

/**
 * gets caller function of this function (used on query builder) to builder the query parameters
 * @return string
 */
function getCaller()
{
    $trace = debug_backtrace();
    $name = $trace[2]['function'];
    return empty($name) ? 'global' : $name;
}

/**
 * send mail function
 * @param $recipient
 * @param $subject
 * @param $body
 */
function sendMail($recipient, $subject, $body)
{
    //TODO: read mail body from html template as body should be template url
    //TODO : more error handling
    try {
        mail($recipient, $subject, $body);
    } catch (\Exception $e) {
        die($e->getMessage());
    }
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

function checkIfFileExists($filePath)
{
    return file_exists($filePath);
}