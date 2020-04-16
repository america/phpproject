<?php
$title = "編集画面";
?>
<html>
    <head>
<!--    <script src="../js/jquery-3.3.1.js"></script>-->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style01.css">
       <meta charset="utf-8">
       <title><?php print $title ?></title>
    </head>
    <body onload="start()">

	<script>

	 function start() {

	     //var id = $('input:hidden[name="id"]').val();
             var id = $('#my-form [name=id]').val();
	     //var word = $('input:hidden[name="word"]').val();
	     var word = $('#my-form [name=word]').val();

             console.log("id="+id);
	     console.log("word="+word);

	 }
	</script>      
    <center>
	<hr>
	<h2><?php print $title ?></h2>
	<hr>
       <?php
           $id = $_POST['id'];
           $word = $_POST['word'];
       ?>
       <form action="fighting_update.php" method="post">
           <table>
               <tr><td><textarea name="word" cols="25" rows="4" ><?php print $word ?></textarea></td></tr>
               <tr><td><input id="submit_button" type="submit" value="更新する"></td></tr>
	   </table>
       </form>
       <h2><a href="javascript:history.back();">検索結果画面に戻る</a></h2>
       <h2><a href="http://america66.work/">TOPへ</a></h2>
    </center>
    </body>
</html>
