<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once(dirname(__FILE__) . '/sql/dsn.php');
require_once(dirname(__FILE__) . '/sql/com.php');
require_once(dirname(__FILE__) . '/../conf/conf.php');

function roll_contract_category(){
    $dsn1 = dsn();
    $stmt1 = $dsn1->prepare(SQL_LOAD_CONF_CONTRACT);
    $stmt1->execute();
    $stmt1->bind_result($row1);
    $stmt1->fetch();

    $selection1 = explode(",",$row1);
    $cnt1 = count($selection1);
    $rtn1 = "";
    for($i1 = 0; $i1 < $cnt1; $i1++){
        $rtn1 = $rtn1 . '<option value="'.$selection[$i].'">'.$selection[$i].'</option>';
    }

    return $rtn1;
}

function roll_client_tel_category(){
    $dsn = dsn();
    $stmt = $dsn->prepare(SQL_LOAD_CONF_TEL);
    $stmt->execute();
    $stmt->bind_result($row);
    $stmt->fetch();

    $selection = explode(",",$row);
    $cnt = count($selection);
    $rtn = "";
    for($i = 0; $i < $cnt; $i++){
        $rtn = $rtn . '<option value="'.$selection[$i].'">'.$selection[$i].'</option>';
    }

    return $rtn;
}


function roll_client_category(){
    $dsn = dsn();
    $stmt2 = $dsn->prepare(SQL_LOAD_CONF_CLIENT);
    $stmt2->execute();
    $stmt2->bind_result($row2);
    $stmt2->fetch();

    $selection2 = explode(",",$row2);
    $cnt2 = count($selection2);
    $rtn2 = "";
    for($i = 0; $i < $cnt2; $i++){
        $rtn2 = $rtn2 . '<option value="'.$selection2[$i].'">'.$selection2[$i].'</option>';
    }

    return $rtn2;
}