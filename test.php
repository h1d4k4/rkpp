<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once('lib/sql/dsn.php');
require_once('lib/sql/com.php');
require_once('conf/conf.php');

//echo password_hash("Tomoaki0915",PASSWORD_DEFAULT);
//$dsn = dsn();
//$uid = "admin";
//$stmt = $dsn->prepare(SQL_LOGIN_AUTH);
//$stmt->bind_param("s",$uid);
//$stmt->execute();
//$stmt->bind_result($q_pass1);
//$stmt->fetch();

//if (password_verify("Tomoaki0915",$q_pass1)) {
//    $dsn = dsn();
//    echo $uid;
//    $stmt2 = $dsn->prepare(SQL_SESSION_VERIFY);
//    $stmt2->bind_param("s",$uid);
//    $stmt2->execute();
//    $stmt2->bind_result($q2_u_date);
//    $stmt2->fetch();
//    echo $q2_u_date;
//    $now = date('U');
//} else {
//    echo 'Invalid password.';
//}
//echo password_hash("Tomoaki0915",PASSWORD_DEFAULT);
$dsn = dsn();
$stmt = $dsn->prepare(SQL_LOAD_CONF_CONTRACT);
$asdf = "contract_category";
$stmt->execute();
$stmt->bind_result($row);
$stmt->fetch();

$selection = explode(",",$row);
$cnt = count($selection);
$rtn ="";
for($i = 0; $i < $cnt; $i++){
    $rtn = $rtn . '<option value="'.$selection[$i].'">'.$selection[$i].'</option>';
}
echo $rtn
?>