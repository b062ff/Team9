<?php
error_reporting(E_ALL);              // エラー出力のレベルを設定します
ini_set("display_errors", "On");     // 画面上にエラー出力を表示する設定にします
$error_message = array();
$tosay =array();
// 変更：MySQLに接続する
$mysqli = new mysqli("localhost", "root", "", "home");


//投稿されたときの処理(DBに保存)
if(isset($_POST["save"])){
    if(!strlen($_POST["body"])){
        $error_message[]="本文を入力してください。";
    }

    if(!count($error_message)){
        $stmt = $mysqli->prepare("INSERT INTO post (body, nickname,pich) VALUES (?, ?,?)");     // 変更
        $stmt->bind_param("sss",$_POST["body"],$_POST["nickname"],$_POST["pich"]);
        $stmt->execute();
    }
}

//再生する方法
if(isset($_POST["hometa"])){
    if(!strlen($_POST["say"])){
        $error_message[]="ほめる言葉がない";
    }
    $tosay=$_POST["say"];
}

$result = $mysqli->query("SELECT * FROM post"); // 表示する項目

$home_list = array();
while ($home = $result->fetch_array()) {      // 変更
  $home_list[] = $home;                        // 変更
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>サンプルほめ</title>
    <link href="src/style.css" rel="stylesheet" type="text/css" />
    <script  type="text/javascript" src="src/index.js" charset="utf-8"></script>
    </head>
    <body>
      <h1>ほめほめ</h1>
     
      <?php if($error_message){
          foreach($error_message as $error){
              echo($error);
          }
      }
      ?>
      <?php foreach($home_list as $home){ ?>
        
        <h4> <?php echo($home["body"]);?></h4>       
        <h5><?php echo($home["nickname"]);?></h5>
        <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
          <input type="hidden" name="say" value="<?php echo($home["body"])?>">
          <input name="hometa" type="submit" value="選択">
        </form>
      <?php } ?>

       <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
        <table>
        <tr>
           <th>ニックネーム</th>
           <td><input type="text" name="nickname" size="30"></td>
        </tr>
        <tr colspan="2">
          <th>ほめてみよう</th>
          <td colspan="2"><textarea name="body" cols="50" rows="5"></textarea></td>
        </tr>
        <tr>
          <th>ピッチ</th>
          <td><input type="number" name ="pich",value="1",step="0.1",min="-2",max="2"></td>
        </tr>
        </table>
        <input name="save" type="submit" value="投稿する">
      </form>

      <?php if($tosay){?>
      <form class="input" id="voice-form">
       <input type="hidden" name="speech" id="speech" value = <?php echo($tosay)?> />
       <input type="button" class="circlebutton" value="再生" onclick="ToSayClick();"/>
      </form>
        
        <?php } ?>

    </body>
</html>
