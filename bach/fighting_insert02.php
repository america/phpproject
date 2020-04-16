<?php

// ログインしているか確認
session_start();
$id = $_SESSION['id'];
if(!$id)
  include './fighting_login02.php';
else
  print $id . 'さんログイン中';

$title = "処理結果";

$input_screen = "fighting_insert01.php";

?>
<html>


<head>
    <link rel="stylesheet" type="text/css" href="css/style01.css">
    <meta charset="utf-8">
    <title><?php print $title ?></title>
</head>
<body>
<div style="text-align: center;">
    <hr>
    <?php
    include("../function/const.php");
    try {
        $ini_array = parse_ini_file("../settings.ini", true);

        $first_section = $ini_array["first_section"];

        $host = $first_section["host"];
        $user = $first_section["user"];
        $pass = $first_section["pass"];
        $db = $first_section["db"];

        $pdo = new PDO("mysql:host=" . $host .";dbname=" . $db . ";charset=utf8mb4",
            $user,
            $pass,
            [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        $stmt = $pdo->prepare("INSERT INTO magicword (word) VALUES(TRIM(:word))");
        //print nl2br($_POST['word']);
        $stmt->bindParam(':word', $_POST['word'], PDO::PARAM_STR);

        //$stmt->execute(array($_POST['word']));
        $stmt->execute();

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        print "<a href=" . $input_screen . ">入力画面へ戻る</a>";
        die();
    }
    ?>
    <h1><?php print $title ?></h1>
    <hr>
    <?php
    $sanitized_word = htmlspecialchars($_POST['word']);
    print nl2br($sanitized_word);
    ?>
    <hr>
    言葉を登録しました。<br />
    <?php
    print "<h2><a href=\"" . $input_screen . "\">入力画面へ戻る</a><h2>";
    print "<h2><a href=" . TOP_PAGE . ">TOPへ</a></h2>"
    ?>
  <form action="fighting_logout.php" method="post">
    <input id="submit_button" type="submit" value="ログアウトする">
  </form>
</div>
</body>
</html>
