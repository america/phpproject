<?php
/**
 * Created by PhpStorm.
 * User: takashi
 * Date: 20/03/29
 * Time: 14:43
 */

// 設定
define('LOCATION', '/');  // ログアウト後飛び先


/**
 * ログアウト処理
 */
function session_off()
{
  session_start();
  setcookie(session_name(), "", time() - 42000);  // クッキーを消す
  $_SESSION = array();  // セッション変数を消す
  session_destroy();  // セッションファイルを消す
  header("Location: " . LOCATION);
  exit;
}

session_off();

