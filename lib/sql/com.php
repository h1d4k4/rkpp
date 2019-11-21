<?php
define('SQL_INPUT_ADDRESS', 'INSERT INTO address (name,birthday,postalcode,pref,city,address,address2) VALUES (?,?,?,?,?,?,?)');
define('SQL_SESSION_DEL', 'DELETE FROM ses WHERE uid = ?');
define('SQL_SESSION_WRITE', 'INSERT INTO ses (uid,a_date,u_date,sid) VALUES (?,?,?,?)');
define('SQL_SESSION_VERIFY', 'SELECT u_date FROM ses WHERE uid = ?');
define('SQL_LOGIN_AUTH', 'SELECT password FROM user WHERE uid = ?');
define('SQL_USER_NAME', 'SELECT name FROM user WHERE uid = ?');
define('SQL_LOG_WRITE', 'INSERT INTO log (date,action,user,detail) VALUES (?,?,?,?)');
define('SQL_LOCKOUTCHECK', 'SELECT u_date FROM ses WHERE uid = ?');
define('SQL_CLEAN_SESSION', 'DELETE FROM ses WHERE u_date <= ?');
define('SQL_AUTH_CHECK', 'SELECT authority FROM user WHERE uid = ?');
define('SQL_LOAD_CONF_CONTRACT', 'SELECT contract_category FROM conf');
define('SQL_LOAD_CONF_TEL', 'SELECT tel_category FROM conf');
define('SQL_LOAD_CONF_CLIENT', 'SELECT client_category FROM conf');
define('SQL_SERCH_CONTACT', 'SELECT * FROM contract WHERE id = ? OR category = ? OR client_id = ? OR address_id = ?' );
?>