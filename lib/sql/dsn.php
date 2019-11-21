<?php
require_once(dirname(__FILE__) . '/../../conf/conf.php');

//db_con
function test_connect(){
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if ($link->connect_error) {
        return mb_convert_encoding($link->connect_error, "UTF-8", "Shift-JIS");
        exit();
    } else {
        $link->set_charset("utf8");
        return 'TRUE';
    }
    $link->close();
}
//db_query
function dsn(){
    $link = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if ($link->connect_error){
        return mb_convert_encoding($link->connect_error, "UTF-8", "Shift-JIS");
        exit();
    }else{
        $link->set_charset("utf8");
    }
    return $link;
}

//db_con_close
function dsn_close($dsn){
    $dsn->close();
    return 0;
}
?>