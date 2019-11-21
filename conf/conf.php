<?php
// RKPP設定ファイル
// ここでは、RKPPのデータベースの設定などを行えます
// 表記の際に、""を削除しないようご注意ください

// SECTION 1 (MySQL 接続設定)
// DB_SERVER: MySQLサーバアドレス
// DB_NAME: DB名
// DB_USER: DBに接続するためのユーザID
// DB_PASS: DBに接続するためのパスワード
define("DB_SERVER","localhost");
define("DB_NAME","rkpp");
define("DB_USER","rkpp_user");
define("DB_PASS","Tomoaki0915");

// SECTION 2 (ユーザログイン設定)
// この設定に関しては、必ず設定項目の説明を読んでください
// [SESSION_VALIDATION_DATE]
// 説明: ログインの有効期限を設定します。
// 　　  この有効期限内はロックアウトされ、再ログインできません
// 　　  ただし、ログアウトを行った場合は、再ログイン可能となります
define("SESSION_VALIDATION_TIME", 3600);

// SECTION 3 (デベロッパ設定)
// 通常利用しません。
define("CONF_FLG_DISPLAYERR", 1);
define("CONF_REPORT_ERROR", "E_ALL");
?>