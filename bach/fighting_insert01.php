<?php

// ログインしているか確認
session_start();
$id = $_SESSION['id'];
if(!$id) // ログインしていない場合
{
  include './fighting_login01.php';
}

print $id . 'さんログイン中';

$title = "入力画面";

?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style01.css">
    <meta charset="utf-8">
    <title><?php print $title ?></title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/fighting_insert01.js"></script>
</head>
<body onload="document.form01.word.focus()">
<?php include("../function/const.php");
?>
<div style="text-align: center;">
    <hr>
    <h2><?php print $title ?></h2>
    <hr>
    <form name="form01" action="fighting_insert02.php" method="post">
        言葉を入力してください。(255文字以内)
        <table border="0" align="center">
            <tr>
                <td><textarea id="word" name="word" cols="50" rows="6" maxlength="255" required></textarea></td>
            </tr>
            <tr>
                <td>
                    現在の文字数：<span id="txtnum">0</span><br/>
                    残り文字数 ：<span id="txtmax">255</span>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input id="submit_button" type="submit" value="登録する">
                    <input id="reset_button" type="reset">
                    <?php echo "<h2><a href=" . TOP_PAGE . ">TOPへ</a></h2>" ?>
                </td>
            </tr>
        </table>
    </form>
  <form action="fighting_logout.php" method="post">
    <input id="submit_button" type="submit" value="ログアウトする">
  </form>
</div>
</body>
</html>
