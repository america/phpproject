<?php

// ログインしているか確認
session_start();
$id = $_SESSION['id'];
if(!$id)
  include './fighting_login01.php';

print $id . 'さんログイン中';

$title = "検索結果";

?>
<!DOCTYPE html>
<html>

<head>
    <!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style01.css">
    <meta charset="utf-8">
    <title><?php print $title ?></title>
</head>
<body>

<script>
    $(function(){
        $('.update').click( function(){
            event.preventDefault();
            //console.log("a");
            var d = $(this.form).serialize();
            $.ajax({
                type:"POST",
                url:"./fighting_update.php",
                dataType:"json",
                data:d,
            }).done(function(result){

                console.log("result="+result);
                var res = {};
                try {
                    res = $.parseJSON(result);
                } catch (e) {
                    console.log("parse error")
                }

                //$('.result').html(res.message);
                $str = result["message"];
                $str += "<br />"
                $str += result["id"];
                $str += "<br />"
                $str += result["word"];

                $('.result').html($str);
                //alert(data);
                console.log(res);

            }).fail(function(xhr, textStatus, errorThrown){
                //$("#XMLHttpRequest").html("XMLHttpRequest : " + jqXHR.status);
                var res = {};
                try {
                    console.log("xhr.responseText="+xhr.responseText);
                    res = $.parseJSON(xhr.responseText);
                } catch (e) {
                    console.log("parse error");
                }
                $("#XMLHttpRequest").html("XMLHttpRequest : " + xhr.code);
                $("#textStatus").html("textStatus : " + textStatus);
                $("#errorThrown").html("errorThrown : " + errorThrown.message);
                //$('.result').html(data);
                console.log(res);
            });
            //event.stopPropagation();

        });

    });

    $('form').submit(function(event) {
        event.preventDefault();

        //post()の処理をここに記述する
    });


    function textChanged(form) {
        console.log("text was changed.");
        //this.form.button.disabled = false;
        //console.log($('.update').disabled.value);
        //$('.update').disabled = false;
        form.update.disabled = false;
        var elements = form.elements;
        console.log(elements);
        console.log("elements.length=" + elements.length);
        for (var i = 0; i < elements.length; i++) {
            if (elements[i] === 'button') {
                elements[i].disabled = false;
            }
        }
    }

</script>

<div align="center">
    <hr>
    <?php
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

        $sql = "select id, word from magicword where word like :keyword";

        $keyword = "";
        if(isset($_POST['word'])) {
            $keyword = $_POST['word'];
            //	} else if(isset($_GET['word'])) {
            //	  $keyword = $_GET['word'];
        }

        $stmt = $pdo->prepare($sql);

        //echo $_POST['word'];

        $keyword = "%".$keyword."%";

        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);

        $stmt->execute();

        //$stmt->debugDumpParams();

        //fetchAllで結果を全件配列で取得
        $all = $stmt->fetchAll();

    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        print "<a href=\"fighting_select01.php\">検索画面へ戻る</a>";
        die();
    }
    ?>
    <h1><?php print $title ?></h1>
    <hr>

    <div class="result" style="height:200px; width:400px; overflow-y:scroll;">

        <table border="1" align="center">

            <?php
            print count($all)."件ヒットしました。";
            //var_dump($all);
            foreach($all as $loop) {

                print "<tr>\n";
                print "<form>\n";
                print "<td>\n";
                print '<input type="hidden" name="id" value="'.$loop['id'].'"/>';
                print $loop['id']."\n";
                print "</td>\n";
                print "<td>\n";

                $sanitized_word = htmlspecialchars($loop['word']);
                print '<textarea name="word" cols="25" rows="4"  value="'.$sanitized_word.'" class="word" onchange="textChanged(this.form)">'.$sanitized_word.'</textarea>'."\n";
                print "</td>\n";
                print "<td>\n";
                //print '<input type="button" value="更新" class="update" />'."\n";
                print '<button name="update" class="update" disabled>更新</button>'."\n";
                print "</td>\n";
                print "</form>\n";
                print "</tr>\n";

            }
            ?>

        </table>
    </div>
    <div id="XMLHttpRequest"></div>
    <div id="textStatus"></div>
    <div id="errorThrown"></div>
    <hr>

    <h2><a href="fighting_select01.php">検索画面へ戻る</a></h2>
    <h2><a href="http://america66.work/">TOPへ</a></h2>
    <form action="fighting_logout.php" method="post">
      <input id="submit_button" type="submit" value="ログアウトする">
    </form>
</div>
</body>
</html>
