<?php
session_start();
ini_set('display_errors', 1);
require_once(dirname(__FILE__) . '/../lib/sql/dsn.php');
require_once(dirname(__FILE__) . '/../lib/session.php');

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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
</head>
<body>
<p class="text-right">ようこそ! 【<?php echo $_SESSION['uname']?>】様<br>ログイン時間: 【<?php echo date('Y/m/d H:i:s',$_SESSION['login_date']);?>】</p>
<div class="container">
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
    }
?>
<a href="./serch-p.php"><button class="btn btn-primary btn-block">契　約　者　検　索</button></a><br>
<a href="./serch-.php"><button class="btn btn-secondary btn-block">契　約　先　検　索</button></a><br>
</div>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>