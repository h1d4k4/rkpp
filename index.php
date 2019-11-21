<?php
ini_set('display_errors', 0);
require_once('lib/sql/dsn.php');

$com = test_connect();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>RKPP</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
        header('Location: ./login.php');
    }
?>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
