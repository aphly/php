<?php
function debug($var = null, $vardump = false) {
    echo '<pre>';
    $vardump = empty($var) ? true : $vardump;
    if($vardump) {
        var_dump($var);
    } else {
        print_r($var);
    }
    exit();
}

//只替换一次
function str_replace_once($needle, $replace, $haystack) {
    $pos = strpos($haystack, $needle);
    if ($pos === false) {
        return $haystack;
    }
    return substr_replace($haystack, $replace, $pos, strlen($needle));
}

