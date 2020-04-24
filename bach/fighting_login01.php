<?php
/**
 * Created by PhpStorm.
 * User: takashi
 * Date: 20/03/29
 * Time: 14:43
 */

include '../function/const.php';

$login = req('login');
if (!empty($login))
{
//  print('login =' . $login);
  login();
}

// ログインしているか確認
session_start();
$id = $_SESSION['id'];
//print('id = ' . $id. '<br>');

if (!$id) // ログインしていない場合
{
  echo <<<EOM
  <script type='text/javascript'>
  
  // function showConfirmDialog(message, resolve, reject) {
  //   if (window.confirm(message)) {
  //     // return Promise.resolve();
  //     return resolve;
  //   }
  //   // return Promise.reject();   
  //   return reject;
  // }

function confirmExPromise(message) {
  if(window.confirm(message)) {
    return Promise.resolve();
  }
  return Promise.reject();
}
//----------------

function executeTask() {
  // TODO PHPのpage_login()関数を呼びたい
  console.log('OK!');

  let url = 'https://www.america66.work/bach/fighting_login01.php?login=1';
  
  return new Promise(function (resolve) { 
    // インスタンスを作成する
    let xhr = new XMLHttpRequest();
  
    // 指定のサーバーと通信を開始する
    xhr.open('GET', url);
    xhr.send();
  
    // 通信が正常に終了したかを確認する
    xhr.onreadystatechange = function() {
      if(xhr.readyState === 4 && xhr.status === 200) {
        // サーバーから取得したデータを使う
        // window.alert('通信正常終了')
      }
      else {
        die('通信異常終了')
      }
  
  
  
   
  }

  });
  
}

function cancelTask() {
  // TODO トップページに移動したい
  console.log('Cancel!');
  setTimeout(function() {
    location.href = 'https://www.america66.work';
 }, 0);
  
}

function one(node, event, callback) {
  let handler = function(e) {
    callback.call(this, e);
    node.removeEventListener(event, handler);
  };
  node.addEventListener(event, handler);
}

one(window, 'DOMContentLoaded', function(event) {
  // 確認ダイアログ表示
  confirmExPromise('ログインしますか?')
    .then(executeTask)  // OK時の処理
    .catch(cancelTask); // Cancel時の処理
});

  </script>
EOM;

  page_login();
}

// ユーザ名がセットされているかを最終確認
if (empty($id)) die("ログインに失敗しました。");


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
//  print('login\n');
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
} catch (Exception $e) {
  die();
}

}