<?php

$projectname = "workshop";

//define('projectroot', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') , true); // For PHP 7
//define('projectroot', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/' . $projectname, true); //For PHP 7
define('projectroot', filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/' . $projectname, false); //For PHP 8

//$webadress = 'midnytupdates.com/' . $projectname;

$defaultuserpass = "Pass1234,";

//Function for Randompassword Generation
function GenRandomPass(
        $length = 8,
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ#$@!*&%[]'
) {
    $str = '';
    $keysize = strlen($keyspace);
    $max = mb_strlen($keyspace, '8bit') - 1;

    if ($max < 1) {
        throw new Exception('$keyspace must be at least two characters long');
    }
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
}

function DefaultTimezone() {
    date_default_timezone_set("Africa/Accra");
}

//Setting default TImezone to Africa/ Accra - GMT 00
DefaultTimezone();

function CustomizeDate($originalDate) {
    return date("M d, Y", strtotime($originalDate));
}

function CustomizeTime($originalTime) {
    return date("g:i A", strtotime($originalTime));
}

$currentdatetime = date('M d, Y - g:i A', time());

function base64_encode_url($string) {
//    return rtrim( strtr( base64_encode( $string ),'+/','-_' ), '=' );
    $string = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    $string = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    $string = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
    return $string;
}

function base64_decode_url($string) {
    $string = base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
    $string = base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
    $string = base64_decode(str_replace(['-', '_'], ['+', '/'], $string));
    return $string;
}

function SortAllCharsNat($w) {
    $letters = str_split($w);
    natcasesort($letters);
    $ret = "";
    foreach ($letters as $letter) {
        $ret .= $letter;
    }
    return $ret;
}

?>
