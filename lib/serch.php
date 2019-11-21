<?php
require_once(dirname(__FILE__) . '/sql/dsn.php');
require_once(dirname(__FILE__) . '/sql/com.php');
require_once(dirname(__FILE__) . '/../conf/conf.php');
ini_set('display_errors', CONF_FLG_DISPLAYERR);
error_reporting(CONF_REPORT_ERROR);

function serch_client($id,$name,$department,$category,$tel){
    $dsn = dsn();
    $id = $dsn->real_escape_string($id);
    $name = $dsn->real_escape_string($name);
    $department = $dsn->real_escape_string($department); 
    $tel = $dsn->real_escape_string($tel);
    $category = $dsn->real_escape_string($category);
    $sql1="";

    $sql0 = "SELECT * FROM client WHERE ";
    if ($id != ""){
        $sql1 = "id = '" . $id . "' "; 
    }
    if ($name != ""){
        if($sql1 != ""){
            $sql1 = $sql1. "OR company LIKE '%".$name."%' ";
        }else{
            $sql1 = $sql1. "company LIKE '%".$name."%' ";
        }
    }
    if ($department != ""){
        if($sql1 != ""){
            $sql1 = $sql1. "OR department LIKE '%".$department."%' ";
        }else{
            $sql1 = $sql1. "department LIKE '%".$department."%' ";
        }
    }
    if ($tel != ""){
        if($sql1 != ""){
            $sql1 = $sql1. "OR tel1 LIKE '%".$tel."%' OR tel2 LIKE '%".$tel."%' ";
        }else{
            $sql1 = $sql1. "tel1 LIKE '%".$tel."%' OR tel2 LIKE '%".$tel."%' ";
        }
    }
    if ($category != ""){
        if($sql1 != ""){
            $sql1 = $sql1. "OR client_category = '".$category."'";
        }else{
            $sql1 = $sql1. "client_category = '".$category."'";
        }
    }

    $sql = $sql0. $sql1;
    //return $sql;
    $stmt_client = $dsn->prepare($sql);
    //id = ? OR company = ? OR department = ? OR tel1 = ? OR tel2 = ? OR client_category = ?
    //$stmt_client->bind_param("isssss",$id,$name,$department,$tel,$tel,$category);
    $stmt_client->execute();
    $stmt_client->bind_result($rid,$rcompany,$rdepartment,$rpostalcode,$rpref,$rcity,$raddress,$raddress2,$rtel1,$rtel1_category,$rtel2,$rtel2_category,$rclient_category,$rmemo);
    $result = $stmt_client->get_result();
    $row = $result->fetch_all();

    $cnt = count($row);

    if($cnt == 0){
        $res = "FALSE";
    }else{
        $rtn1 = "";
        $rtn0 = '<div class="card card-body"><table class="table"><thead><tr><th>ID</th><th>社名</th><th>部署名</th><th>電話番号1</th><th>電話番号2</th><th>カテゴリ</th><th>メモ</th></tr><tbody>';
        for($i=0;$i<$cnt;$i++){
            $rtn1 = $rtn1 .'</th><th><button type="button" class="btn btn-primary" onClick="serch_client_write('.$row[$i][0].');">' .$row[$i][0] .'</button></th><th>' .$row[$i][1] .'</th><th>' .$row[$i][2] .'</th><th>' .$row[$i][8] .'</th><th>' .$row[$i][10] .'</th><th>' .$row[$i][12] .'</th><th>' .$row[$i][13] .'</th></tr>';
        }
        $rtn2 = '</tbody></table></div>';
        $res = $rtn0 .$rtn1 .$rtn2;
    }
    return $res;
    //return $row;
}

function serch_contract($cont_id,$cont_category,$client_id,$address_id){
    $dsn = dsn();
    $cont_id = $dsn->real_escape_string($cont_id);
    $cont_category = $dsn->real_escape_string($cont_category);
    $client_id = $dsn->real_escape_string($client_id);
    $address_id = $dsn->real_escape_string($address_id);


}
?>