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
<p class="text-right">ようこそ! 【<?php echo $_SESSION['uname']?>】様<br>ログイン時間: 【<?php echo date('Y/m/d H:i:s',$_SESSION['login_date']);?>】</p>
<div class="container">
<?php
if (authority($_SESSION['uid'])=="root"){
    echo '<p class="center"><h1>【管理者ログイン】ポータル画面</h1></p>';
} elseif (authority($_SESSION['uid'])=="manager"){
    echo '<p class="center"><h1>【マネージャーログイン】ポータル画面</h1></p>';
} else {
    echo '<p class="center"><h1>【一般者ログイン】ポータル画面</h1></p>';
}
?>
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
    }
?>
<a href="contract/index.php"><button class="btn btn-primary btn-block">契　約　メ　ニ　ュ　ー</button></a><br>
<a href="record/index.php"><button class="btn btn-secondary btn-block">レ　コ　ー　ド　メ　ニ　ュ　ー</button></a><br>
<a href="report/index.php"><button class="btn btn-success btn-block">帳　票　メ　ニ　ュ　ー</button></a><br>
<?php 
if (authority($_SESSION['uid'])=="root"){
    echo '<a href="manage/index.php"><button class="btn btn-warning btn-block">管　理　メ　ニ　ュ　ー</button></a><br>';
} elseif (authority($_SESSION['uid'])=="manager"){
    echo '<a href="manage/index.php"><button class="btn btn-danger btn-block">管　理　メ　ニ　ュ　ー</button></a><br>';
} else {
    echo '<button class="btn btn-secondary btn-block disabled">管　理　メ　ニ　ュ　ー　【権　限　が　あ　り　ま　せ　ん】</button><br>';
}
?>
<br>
<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#logout">ロ　グ　ア　ウ　ト</button>
</div>
<div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="logout-label">ログアウト確認 RKPP-LOGOUT-000</div></h4>
            </div>
            <div class="modal-body">
                <label>ログアウトしますか?</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">キャンセル</button>
                <a href="./logout.php"><button type="button" class="btn btn-danger">ログアウト</button></a>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/usr/script.js"><script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>