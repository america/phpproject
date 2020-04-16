<?php
/**
 * Created by PhpStorm.
 * User: takashi
 * Date: 20/03/29
 * Time: 14:43
 */

// 設定
define('LOCATION', '/');  // ログアウト後飛び先

$login = req('login');
if (!empty($login))
{
  login();
}

// ログインしているか確認
session_start();
$id = $_SESSION['id'];

if (!$id) // ログインしていない場合
{
  echo <<<EOM
  <script type='text/javascript'>
  
  function showConfirmDialog(message, resolve, reject) {
    if (window.confirm(message)) {
      return Promise.resolve();
    }
    return Promise.reject();                                                                                                                        
}

//----------------
// 共通関数
//----------------
function confirmExPromise(message) {
  let _promise = new Promise(function(resolve, reject) {
    // 別途定義されたコールバック関数を受け取る関数を呼び出す
    showConfirmDialog(message, resolve, reject);
  });
  // 戻り値はPromise
  return _promise;
}
//----------------

function executeTask() {
  // TODO PHPのpage_login()関数を呼びたい
  window.alert("OK");

  }

function cancelTask() {
  // TODO トップページに移動したい
  console.debug('Cancel!');
}

function method01() {
  // 確認ダイアログ表示
  confirmExPromise('ログインしますか?')
    .then(executeTask)  // OK時の処理
    .catch(cancelTask); // Cancel時の処理
}


  </script>
EOM;
//  print("Confirmation = " . $Confirmation);

//  if ($Confirmation == true) {
//    page_login();
//  } else {
//    header("Location: " . LOCATION);
//  }
}

//-------------------------------------------------------//
// 処理がここまでたどり着けば認証完了ということになる。          //
// このスクリプトの処理はここまでで終わり、                     //
// include(require)元があればそちらに処理を移す              //
//-------------------------------------------------------//

/**
 * ログイン用ページを表示
 */
function page_login()
{
  // ログインフォーム
  echo <<<EOT
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style01.css">
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="Set-Cookie" content="ON=1; expires=Tue, 1-Jan-2030 00:00:00 GMT" />

</head>
<body>
<div style="text-align: center;">
<form action="$_SERVER[‘SCRIPT_NAME’]" method="post">
[ログイン認証]<br />
スタッフ名:<input type="text" name="id" size="10" maxlength="20" /><br />
パスワード:<input type="password" name="pass" size="20" maxlength="20" /><br />
<input type="hidden" name="login" value="1" />
<input type="submit" value="認証" />
</form>
</div>
</body>
</html>
EOT;
  exit;
}

/**
 * リクエストデータ取得
 * @param $key
 * @return mixed|string
 */
function req($key)
{
  return (isset($_REQUEST[$key]) ? $_REQUEST[$key] : '');
}

/**
 * 認証を行う
 */
function login()
{
try {
  $ini_array = parse_ini_file("../settings.ini", true);

  $first_section = $ini_array["first_section"];

  $host = $first_section["host"];
  $user = $first_section["user"];
  $pass = $first_section["pass"];
  $db = $first_section["db"];

  $pdo = new PDO("mysql:host=".$host.";dbname=".$db.";charset=utf8mb4",
    $user,
    $pass);

  // 画面からスタッフ名とパスワードを取得する
  $_REQUEST[session_name()] = '';
  $id = req('id'); // 名前
  $pass = req('pass'); // パスワード

  $sql = "select staff_name, password from admin_table where staff_name = :staff_name";

  $stmt = $pdo->prepare($sql);
  // スタッフ名をバインドする
  $stmt->bindParam(':staff_name', $id, PDO::PARAM_STR);

  //クエリを実行
  $stmt->execute();

  //$stmt->debugDumpParams();

  //結果を取得
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  //結果から値を取得する
  $staff_name = $result['staff_name']; // スタッフ名
  $staff_pass = $result['password'];  // パスワード

  if (!empty($id) && $id === $staff_name
    && !empty(md5($pass)) && md5($pass)=== $staff_pass) {
    // ログイン認証成功の処理
    session_start();
    $_SESSION['id'] = $id;
    return true;
  }

  print("スタッフ名かパスワードが間違っています。");
  return false;

} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";

  die();
}

}