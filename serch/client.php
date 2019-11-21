<?php
session_start();
require_once(dirname(__FILE__) . '/../lib/sql/dsn.php');
require_once(dirname(__FILE__) . '/../lib/session.php');
require_once(dirname(__FILE__) . '/../lib/parts.php');
require_once(dirname(__FILE__) . '/../lib/serch.php');
ini_set('display_errors', 1);
error_reporting(E_ALL);

$msg = "";
$res = "";
$com = test_connect();
clean_session();
$ch = check_session($_SESSION['uid']);
if ($ch == 0 && authority($_SESSION['uid']) != "root"){
    session_destroy();
    header("Location: ../index.php");
}
if(!isset($_SESSION['uname'])){
    header("Location: ../index.php");
}
if(isset($_POST['submit'])){
    if($_POST['cid'] == "" && $_POST['cname'] == "" && $_POST['ctel'] == "" && $_POST['ccategory'] == "" && $_POST['cdepartment'] == ""){
        $msg = '<div class="mx-4 my-5 alert alert-warning"><strong>エラー</strong><br>検索条件が未入力です<br><strong>解決方法</strong>: 最低1項目の入力が必要です。<br>エラーコード:NU-SERCH-CLIENT-000</div></div>';
    } else {
        $res = serch_client($_POST['cid'],$_POST['cname'],$_POST['cdepartment'],$_POST['ccategory'],$_POST['ctel']);
    }
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
<!-- 必須部品include部 -->
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/usr/script.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<p class="text-right">ようこそ! 【<?php echo $_SESSION['uname']?>】様<br>ログイン時間: 【<?php echo date('Y/m/d H:i:s',$_SESSION['login_date']);?>】</p>
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
    }
    echo $msg;
?>
<div class="container">
<p class="center"><h1>企業情報検索画面</h1></p>
<form action="" method="POST">
<div class="card card-body">
    <div class="form-group">
        <label for="client">企業コード</label>
        <input type="text" class="form-control" id="cid" name="cid" placeholder="企業コード">
    </div>
    <div class="form-group">
        <label for="client">企業名</label>
        <input type="text" class="form-control" id="cname" name="cname" placeholder="企業名">
    </div>
    <div class="form-group">
        <label for="department">部署名</label>
        <input type="text" class="form-control" id="cdepartment" name="cdepartment" placeholder="部署名">
    </div>
    <div class="form-group">
        <label for="tel">電話番号</label>
        <input type="text" class="form-control" id="ctel" name="ctel" placeholder="電話番号">
    </div>
    <div class="form-group">
        <label for="cat">企業分類</label>
        <select class="form-control" id="ccategory"  name="ccategory" placeholder="契約分類">
            <option value="">選択してください</option>
            <?php echo roll_client_category();?>
        </select>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-success" id="submit" name="submit">検索</button>
    </div>
</form>
<?php
if($res=="FALSE"){
    echo "<script>open_blankdata();</script>";
}else{
    echo $res;
}
?>
</div>
</div>

<!-- モーダル記載部 -->
<div class="modal fade" id="none_data" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="none_data-label">確認 ERR-NF-CLIENT-00001</div></h4>
            </div>
            <div class="modal-body">
                <label>該当のデータが存在しませんでした。<br>新規作成しますか？</label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal" onClick="skip_create_client()">はい</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">いいえ</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>