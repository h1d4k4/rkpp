<?php
session_destroy();
ini_set('display_errors', 0);
session_start();
require_once('lib/sql/dsn.php');
require_once('lib/session.php');

$err = "";
$err2 = "";
if(isset($_POST["submit"])){
    if($_POST["uid"] == ""){
        $err = 'IDが未入力です';
    }
    if($_POST["pass"] == ""){
        $err2 = 'パスワードが未入力です';
    }
    if($err != "" || $err2 != ""){
        if($err != "" || $err2 != ""){
            $err = '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>'.$err.'<br>'.$err2.'</div>';
        } else {
            $err = '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>'.$err2.'</div>';
        }
    } else {
        $flg = login($_POST["uid"],$_POST["pass"]);
        if($flg == "9"){
            $err = '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.login($_POST["uid"],$_POST["pass"]).'</div>';
        } elseif ($flg == "1"){
            $err = '<div class="mx-4 my-5 alert alert-warning"><strong>ログインエラー</strong><br>現在ロックアウト中です。しばらくしてからログインしてください<br>緊急の場合は管理者にお問い合わせください<br>エラーコード:LT00-'.ses_lim_time($_POST["uid"]).'</div></div>';
        } elseif ($flg == "2"){
            $err = '<div class="mx-4 my-5 alert alert-warning"><strong>ログインエラー</strong><br>ID/パスワードが間違っています。<br>不明時は管理者までご連絡ください</div></div>';
        } elseif ($flg == "0"){
            header('Location: ./portal.php');
        } else {
            print_r ($flg);
        }
    }
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
<?php echo $err; ?>
    <div class="container">
    <p class="center"><h1>RKPPログイン画面</h1></p>
    <form action="" method="POST">
    <div class="form-group">
        <label for="text1" class="col-sm-2 com-form-label">ログインID</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="uid" name="uid" placeholder="ユーザID">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-sm-2 com-form-label">パスワード</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="pass" name="pass" placeholder="パスワード">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-success" id="submit" name="submit">ログイン</button>
        </div>
    </div>
    </div>
    </form>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
