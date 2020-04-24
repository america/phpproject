<?php
header('Content-type: text/plain; charset= UTF-8');
if(isset($_POST['id']) && isset($_POST['word'])){
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

    $sql = "update magicword set word = :word where id = :id";

    $id = $_POST['id'];
    $word = $_POST['word'];

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':word', $word, PDO::PARAM_STR);

    $result = $stmt->execute();

    if($result) {
      $arr = array (
          "message" => "更新しました。",
          "id"      => $id,
          "word"    => $word
      );
    } else {
      $arr = array (
          "message" => "更新に失敗しました。",
          "id"      => $id,
          "word"    => $word
      );
    }

    echo json_encode($arr);

  } catch (Exception $e) {
    //echo "Error!: " . $e->getMessage() . "<br/>";
    //"code":"E405-001"
    $arr = array ("code" => $e->getcode,"message" => $e->getMessage());
    //$arr = array ("code" => "400", "message" => "おっぱい");
    //echo json_encode($arr);
    //header('Content-Type: application/json');
    //echo {"code":"E405-001","message":"おっぱい"};
    throw $e;
    //die();
  }
} else {
  echo 'FAIL TO AJAX REQUEST';
}

