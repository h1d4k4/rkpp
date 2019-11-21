<?php
session_start();
ini_set('display_errors', 0);
require_once('lib/sql/dsn.php');
require_once('lib/session.php');

$com = test_connect();
clean_session();
$ch = check_session($_SESSION['uid']);
if ($ch == 0 && authority($_SESSION['uid']) != "root"){
    session_destroy();
    header("Location: ./index.php");
}
if(!isset($_SESSION['uname'])){
    header("Location: ./index.php");
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>RKPP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
<?php
$msg = "ログアウト処理中です。そのままお待ちください。<br>";
echo $msg;
$flg = logout_session($_SESSION['uid']);
if($flg === 0){
    header("Location: ./index.php");
} else {
    $msg2 = "処理中にエラーが発生しました。<br>管理者まで連絡してください";
    echo $msg2;
}
?>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>