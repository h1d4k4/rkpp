<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
require_once(dirname(__FILE__) . '/sql/dsn.php');
require_once(dirname(__FILE__) . '/sql/com.php');
require_once(dirname(__FILE__) . '/../conf/conf.php');

function login($uid,$pass){
    session_start();
    $dsn = dsn();
    $uid = $dsn->real_escape_string($uid);
    $pass = $dsn->real_escape_string($pass);
    $now = date('U');
    if(!is_object($dsn)){
        return $dsn;
    } else {
        $stmt = $dsn->prepare(SQL_LOGIN_AUTH);
        $stmt->bind_param("s",$uid);
        $stmt->execute();
        $stmt->bind_result($q_pass);
        $stmt->fetch();
        if(password_verify($pass,$q_pass)){
            // 有効じゃないセッションの確認=>削除
            clean_session();
            // 管理者の場合の時間チェック回避
            $ath = authority($uid);
            if($ath == "root"){
                session_regenerate_id();
                $dsn = dsn();
                $stmt3 = $dsn->prepare(SQL_USER_NAME);
                $stmt3->bind_param("s",$uid);
                $stmt3->execute();
                $stmt3->bind_result($name);
                $stmt3->fetch();
                $_SESSION['uname'] = $name;
                $_SESSION['login_date'] = $now;
                $_SESSION['uid'] = $uid;
                $detail = "操作端末".$_SERVER['HTTP_USER_AGENT']."|| 接続IP:".$_SERVER['REMOTE_ADDR'];
                write_log(date('U'),"特権ログイン: 成功",$uid,$detail);
                return 0;
            }
            // セッション時間のチェック
            $dsn = dsn();
            $stmt2 = $dsn->prepare(SQL_SESSION_VERIFY);
            $stmt2->bind_param("s",$uid);
            $stmt2->execute();
            $stmt2->bind_result($q2_u_date);
            $stmt2->fetch();
            //$now = date('U');
            if($now<$q2_u_date){
                // Lockout
                $dsn = dsn();
                $stmt8 = $dsn->prepare(SQL_LOCKOUTCHECK);
                $stmt8->bind_param("s",$uid);
                $stmt8->execute();
                $stmt8->bind_result($u_d);
                $stmt8->fetch();
                $ud = date('Y/m/d H:i:s',$u_d);
                $dsn = dsn();
                $stmt6 = $dsn->prepare(SQL_LOG_WRITE);
                $act = "ログイン操作: ロックアウト中";
                $ua = $_SERVER['HTTP_USER_AGENT'];
                $detail = "ログイン端末".$ua."|| 接続IP:".$_SERVER['REMOTE_ADDR']."|| ロックアウト解除時間:".$ud;
                $stmt6->bind_param("ssss",$now,$act,$uid,$detail);
                $stmt6->execute();
                session_destroy();
                return 1;
            }
            // 有効セッションなし
            session_regenerate_id();
            $dsn = dsn();
            $stmt3 = $dsn->prepare(SQL_USER_NAME);
            $stmt3->bind_param("s",$uid);
            $stmt3->execute();
            $stmt3->bind_result($name);
            $stmt3->fetch();
            $_SESSION['uname'] = $name;
            $u_date = $now + SESSION_VALIDATION_TIME;
            $dsn = dsn();
            $stmt4 = $dsn->prepare(SQL_SESSION_WRITE);
            $stmt4->bind_param("ssss",$uid,$now,$u_date,session_id());
            $stmt4->execute();
            $stmt5 = $dsn->prepare(SQL_LOG_WRITE);
            $act = "ログイン操作: 認証済み";
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $detail = "ログイン端末".$ua."|| 接続IP:".$_SERVER['REMOTE_ADDR'];
            $stmt5->bind_param("ssss",$now,$act,$uid,$detail);
            $stmt5->execute();
            $_SESSION['login_date'] = $now;
            $_SESSION['uid'] = $uid;
            //OK
            return 0;
        } else {
            //ERROR
            $dsn = dsn();
            //$now = date('U');
            $stmt7 = $dsn->prepare(SQL_LOG_WRITE);
            $act = "ログイン操作: 認証エラー";
            $ua = $_SERVER['HTTP_USER_AGENT'];
            $detail = "ログイン端末".$ua."|| 接続IP:".$_SERVER['REMOTE_ADDR'];
            $stmt7->bind_param("ssss",$now,$act,$uid,$detail);
            $stmt7->execute();
            if ($stmt7===false) {
                print_r($dsn->errorInfo());
            }
            session_destroy();
            return 2;
        }
    }
}

function clean_session(){
    $dsn = dsn();
    $date = date('U');
    $stmt11 = $dsn->prepare(SQL_CLEAN_SESSION);
    $stmt11->bind_param("s",$date);
    $stmt11->execute();
    return 0;
}

function ses_lim_time($uid){
    $dsn = dsn();
    $stmt10 = $dsn->prepare(SQL_LOCKOUTCHECK);
    $stmt10->bind_param("s",$uid);
    $stmt10->execute();
    $stmt10->bind_result($u_d);
    $stmt10->fetch();
    return $u_d;
}

function authority($uid){
    $dsn = dsn();
    $stmt12 = $dsn->prepare(SQL_AUTH_CHECK);
    $stmt12->bind_param("s",$uid);
    $stmt12->execute();
    $stmt12->bind_result($ath);
    $stmt12->fetch();
    return $ath;
}

function un($uid){
    $dsn = dsn();
    $stmt13 = $dsn->prepare(SQL_AUTH_CHECK);
    $stmt13->bind_param("s",$uid);
    $stmt13->execute();
    $stmt13->bind_result($ath);
    $stmt13->fetch();
    return $ath;
}

function check_session($uid){
    $dsn = dsn();
    $stmt14 = $dsn->prepare(SQL_SESSION_VERIFY);
    $stmt14->bind_param("s",$uid);
    $stmt14->execute();
    $stmt14->bind_result($date);
    $stmt14->fetch();
    if ($date == NULL){
        return 0;
    } else {
        return 1;
    }
}

function logout_session($uid){
    session_regenerate_id();
    session_destroy();
    if (authority($uid)=="root"){
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $detail = "操作端末".$ua."|| 接続IP:".$_SERVER['REMOTE_ADDR'];
        write_log(date('U'),"特権ログアウト処理: 正常完了",$uid,$detail);
        return 0;
    }
    $dsn = dsn();
    $stmt15 = $dsn->prepare(SQL_SESSION_DEL);
    $stmt15->bind_param("s",$uid);
    $stmt15->execute();
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $detail = "操作端末".$ua."|| 接続IP:".$_SERVER['REMOTE_ADDR'];
    write_log(date('U'),"ログアウト処理: 正常完了",$uid,$detail);
    return 0;
}

function write_log($date,$act,$uid,$dtl){
    $dsn = dsn();
    $stmt16 = $dsn->prepare(SQL_LOG_WRITE);
    $stmt16->bind_param("ssss",$date,$act,$uid,$dtl);
    $stmt16->execute();
    return 0;
}
?>