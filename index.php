<?php

$title = "オブライエンの日誌";

?>
<html>
<head>
    <meta charset="utf-8">
    <title><?php print $title ?></title>
    <link rel="stylesheet" type="text/css" href="./css/top-style01.css">
</head>
<body>
<hr>
<?php
try {
    $ini_array = parse_ini_file("settings.ini", true);

    $first_section = $ini_array["first_section"];

    $host = $first_section["host"];
    $user = $first_section["user"];
    $pass = $first_section["pass"];
    $db = $first_section["db"];

    $pdo = new PDO("mysql:host=" . $host . ";dbname=" . $db . ";charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

    //SQL(SELECT文)
    $sql = 'select id, word from magicword where id=:id';

    if ($stmt = $pdo->prepare($sql)) {
        $min = 1;
        $max = get_max_rows($pdo);
        //echo "max=".$max;

        $sanitized_word = get_word($min, $max, $stmt);

        print "<center><h4>" . nl2br($sanitized_word) . "</h4></center>" . "\n";
    }

} catch (Exception $e) {
    print "エラー!: " . $e->getMessage() . "<br/>";
    die();
}

function get_word($min, $max, $stmt)
{
    // 乱数を生成する
    $random_num = mt_rand($min, $max);

    $id = $random_num;
    $word = "";

    //print '<input-type="hidden" name="id" value="$id">\n';
    //$id = 92;

    // 条件値をSQLにバインドする
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // 実行
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //var_dump($row);
    if ($row === false) {
        //print "Not found!! id=$id\n";
        get_word($min, $max, $stmt);
    }

    $sanitized_word = htmlspecialchars($row['word']);

    return $sanitized_word;

//    print "<center><h4>" . nl2br($sanitized_word) . "</h4></center>" . "\n";
}

function get_max_rows($pdo)
{

    //SQL(列数カウント用)
    $sql = "select max(id) from magicword";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    //return $stmt->rowCount();
    return $result['max(id)'];

}

?>
<hr>
<div class="top-menu" style="justify-content:space-between;">
    <!-- 左の列 -->
    <div>
    </div>

    <!-- 中央の列 -->
    <div class="container">
        <ul>
            <li>
                <h2><a href="." class="btn-push"><?php print $title ?></a></h2>
            </li>
            <li>
                <h2><a href="./blog/" class="btn-push">ブログ</a></h2>
            </li>
            <li>
                <h2><a href="https://america66.hatenablog.com/" class="btn-push">はてなブログ</a></h2>
            </li>
            <li>
                <h2><a href="https://github.com/america" class="btn-push">GitHub</a></h2>
            </li>
            <li>
                <h2><a href="./bach/fighting_insert01.php" class="btn-push">入力画面</a></h2>
            </li>
            <li>
                <h2><a href="./bach/fighting_select01.php" class="btn-push">検索画面</a></h2>
            </li>
        </ul>

        <script src="https://cdn.jsdelivr.net/npm/vue"></script>
        <script src="js/sample01.js"></script>

    </div>

    <!--右の列-->
    <div>
    </div>
</body>
</html>
