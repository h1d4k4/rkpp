<?php
session_start();
require_once(dirname(__FILE__) . '/../lib/sql/dsn.php');
require_once(dirname(__FILE__) . '/../lib/session.php');
require_once(dirname(__FILE__) . '/../lib/parts.php');
require_once(dirname(__FILE__) . '/../conf/conf.php');
require_once(dirname(__FILE__) . '/../lib/serch.php');
ini_set('display_errors', CONF_FLG_DISPLAYERR);
error_reporting(CONF_REPORT_ERROR);


$msg = "";
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
    if($_POST['contractid'] == "" && $_POST['usecategory'] == "" && $_POST['clientid'] == "" && $_POST['addressid'] == ""){
        $msg = '<div class="mx-4 my-5 alert alert-warning"><strong>エラー</strong><br>検索条件が未入力です<br><strong>解決方法</strong>: 最低1項目の入力が必要です。<br>エラーコード:NU-SERCH-CONTRACT-000</div></div>';
    } else {
        $res = serch_contract($_POST['contractid'],$_POST['usecategory'],$_POST['clientid'],$_POST['addressid']);
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
<p class="text-right">ようこそ! 【<?php echo $_SESSION['uname']?>】様<br>ログイン時間: 【<?php echo date('Y/m/d H:i:s',$_SESSION['login_date']);?>】</p>
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
    }
    echo $msg;
?>
<div class="container">
<p class="center"><h1>契約検索</h1></p>
    <div class="card card-body">
        <form id="contract1" action="" method="POST">
            <div class="form-group">
                <label for="ContractID">契約管理番号</label>
                <input type="text" class="form-control" id="contractid" placeholder="契約管理番号">
            </div>
            <div class="form-group">
                <label for="UseCategory">利用カテゴリー</label>
                <select class="form-control" id="usecategory" placeholder="契約分類">
                    <option value="">選択してください</option>
                    <?php echo roll_contract_category();?>
                </select>
            </div>
            <div class="form-group">
                <label for="clientid">企業コード</label>
                <input type="text" class="form-control" id="clientid" placeholer="企業コード" disabled>
                <button type="button" class="btn btn-info" onClick="open_serch_client()">企業検索</button>
            </div>
            <div class="form-group">
                <label for="addressid">契約者コード</label>
                <input type="text" class="form-control" id="addressid" placeholer="契約者コード" disabled>
                <button type="button" class="btn btn-info" onClick="open_serch_address()">契約者検索</button>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" id="submit" name="submit">検索</button>
            </div>
        </form>
    </div>
    <?php echo $res;?>
</div>
<script src="../js/jquery-3.4.1.min.js"></script>
<script src="../js/usr/script.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>