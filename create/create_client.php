<?php
session_start();
require_once(dirname(__FILE__) . '/../lib/sql/dsn.php');
require_once(dirname(__FILE__) . '/../lib/session.php');
require_once(dirname(__FILE__) . '/../lib/parts.php');
require_once(dirname(__FILE__) . '/../lib/serch.php');
ini_set('display_errors', CONF_FLG_DISPLAYERR);
error_reporting(CONF_REPORT_ERROR);

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
<script src="https://yubinbango.github.io/yubinbango/yubinbango.js" charset="UTF-8"></script>
<p class="text-right">ようこそ! 【<?php echo $_SESSION['uname']?>】様<br>ログイン時間: 【<?php echo date('Y/m/d H:i:s',$_SESSION['login_date']);?>】</p>
<?php
    if($com != 'TRUE'){
        echo '<div class="mx-4 my-5 alert alert-danger"><strong>エラー</strong><br>MySQLとの接続中にエラーが発生しました<br>以下のエラーを管理者までご連絡ください</div><div class="mx-4 my-5 alert alert-info"><strong>■エラー情報■</strong><br>'.$com.'</div>';
    }else{
        
    }
    echo $msg;
?>
<div class="container">
<p class="center"><h1>企業情報登録画面</h1></p>
<form action="" method="POST" class="h-adr" name="create_cl">
<span class="p-country-name" style="display:none;">Japan</span>
<div class="card card-body">
    <div class="form-group">
        <label for="client">企業コード</label>
        <input type="text" class="form-control" id="id" name="id" placeholder="企業コード" disabled>
    </div>
    <div class="form-group">
        <label for="client">企業名</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="企業名">
    </div>
    <div class="form-group">
        <label for="department_l">部署名</label>
        <input type="text" class="form-control" id="department" name="department" placeholder="部署名">
    </div>
    <div class="form-group">
        <label for="postalcode_l">郵便番号</label>
        <input type="text" class="form-control p-postal-code" id="postalcode" name="postalcode" placeholder="郵便番号" maxlength="7">
    </div>
    <div class="form-group">
        <label for="pref_l">都道府県</label>
        <input type="text" class="form-control p-region" id="pref" placeholder="都道府県(自動入力されます)">
    </div>
    <div class="form-group">
        <label for="city_l">市区町村</label>
        <input type="text" class="form-control p-locality" id="city" placeholder="市区町村(自動入力されます)">
    </div>
    <div class="form-group">
        <label for="address_l">番地(不足時は追記すること)</label>
        <input type="text" class="form-control p-street-address p-extended-address" id="address" placeholder="番地(自動入力されます)">
    </div>
    <div class="form-group">
        <label for="address2_l">建物名(ある場合)</label>
        <input type="text" class="form-control" id="address2" placeholder="建物">
    </div>
    <div class="form-group">
        <label for="tel1_l">電話番号1</label>
        <input type="text" class="form-control" id="tel1" name="tel1" placeholder="電話番号1">
    </div>
    <div class="form-group">
        <label for="tel1_category_l">電話番号1:カテゴリ</label>
        <select class="form-control" id="tel1_category" name="tel1_category" placeholder="電話番号1の種類">
            <option value="">選択してください</option>
            <?php echo roll_client_tel_category();?>
        </select>
    </div>
    <div class="form-group">
        <label for="tel2_l">電話番号2</label>
        <input type="text" class="form-control" id="tel2" name="tel2" placeholder="電話番号2">
    </div>
    <div class="form-group">
        <label for="tel2_category_l">電話番号2:カテゴリ</label>
        <select class="form-control" id="tel2_category" name="tel2_category" placeholder="電話番号2の種類">
            <option value="">選択してください</option>
            <?php echo roll_client_tel_category();?>
        </select>
    </div>
    <div class="form-group">
        <label for="cat_l">企業分類</label>
        <select class="form-control" id="category"  name="category" placeholder="契約分類">
            <option value="">選択してください</option>
            <?php echo roll_client_category();?>
        </select>
    </div>
    <div class="form-group">
        <label for="memo_l">メモ</label>
        <textarea class="form-control" id="memo" name="memo" rows="5"></textarea>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-success" onClick="confirm_create()" id="submit2" name="submit2">登録</button>
    </div>
</form>
</div>
</div>

<div class="modal fade" id="confirm_m" tablindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><div class="modal-title" id="none_data-label">確認 ERR-CREATE-CLIENT-00001</div></h4>
            </div>
            <div class="modal-body">
            <form action="" method="POST" name="confirm">
            <div class="form-group">
                <label for="id">企業コード</label>
                <input type="text" class="form-control" id="id" name="id" value="*****登録後自動で付番されます*****" disabled>
            </div>
            <div class="form-group">
                <label for="client">企業名</label>
                <input type="text" class="form-control" id="name" name="name" readonly>
            </div>
            <div class="form-group">
                <label for="department_">部署名</label>
                <input type="text" class="form-control" id="department" name="department" readonly>
            </div>
            <div class="form-group">
                <label for="postalcode_">郵便番号</label>
                <input type="text" class="form-control" id="postalcode" name="postalcode" maxlength="7" readonly>
            </div>
            <div class="form-group">
                <label for="pref_">都道府県</label>
                <input type="text" class="form-control" id="pref" readonly>
            </div>
            <div class="form-group">
                <label for="city_">市区町村</label>
                <input type="text" class="form-control" id="city" readonly>
            </div>
            <div class="form-group">
                <label for="address_">番地(不足時は追記すること)</label>
                <input type="text" class="form-control" id="address" readonly>
            </div>
            <div class="form-group">
                <label for="address2_">建物名(ある場合)</label>
                <input type="text" class="form-control" id="address2" readonly>
            </div>
            <div class="form-group">
                <label for="tel1_">電話番号1</label>
                <input type="text" class="form-control" id="tel1" name="tel1" readonly>
            </div>
            <div class="form-group">
                <label for="tel1_category_">電話番号1:カテゴリ</label>
                <input type="text" class="form-control" id="tel1_category" id="tel1_category" name="tel1_category" readonly>
            </div>
            <div class="form-group">
                <label for="tel2_">電話番号2</label>
                <input type="text" class="form-control" id="tel2" name="tel2" readonly>
            </div>
            <div class="form-group">
                <label for="tel2_category_">電話番号2:カテゴリ</label>
                <input type="text" class="form-control" id="tel2_category" name="tel2_category" readonly>
            </div>
            <div class="form-group">
                <label for="cat_">企業分類</label>
                <input type="text" class="form-control" id="category"  name="category" readonly>
            </div>
            <div class="form-group">
                <label for="memo_">メモ</label>
                <textarea class="form-control" id="memo" name="memo" rows="5" readonly></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success" id="submit" name="submit">登録</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">修正</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>