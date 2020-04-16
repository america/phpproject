<?php

// ログインしているか確認
session_start();
$id = $_SESSION['id'];
if(!$id)
  include './fighting_login01.php';

print $id . 'さんログイン中';

$title = "検索画面";

?>
<html>
    <head>
	<link rel="stylesheet" type="text/css" href="css/style01.css">
	<meta charset="utf-8">
	<title><?php print $title ?></title>
    </head>
    <body>
	<?php include("../function/const.php"); ?>
	<div style="text-align: center;">
	    <hr>
	    <h2>検索画面</h2>
	    <hr>
	    <form action="fighting_select02.php" method="post">
		<table border="0" align="center">
		    <tr>
			<td><textarea name="word" cols="30" rows="3" required></textarea></td>
		    </tr>
		    <tr>
			<td align="left">
			    <input id="submit_button" type="submit" value="検索する">
			    <input id="reset_button" type="reset">
			</td>
		    </tr>
            <tr>
                <td>
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
