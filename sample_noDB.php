<?php
error_reporting(E_ALL);              // エラー出力のレベルを設定します
ini_set("display_errors", "On");     // 画面上にエラー出力を表示する設定にします
$error_message = array();
$tosay =array();


//投稿されたときの処理(DBに保存)
if(isset($_POST["save"])){
    if(!strlen($_POST["body"])){
        $error_message[]="本文を入力してください。";
    }

    if(!count($error_message)){
      echo("投稿成功");
    }
}

//再生する方法
if(isset($_POST["hometa"])){
    if(!strlen($_POST["say"])){
        $error_message[]="ほめる言葉がない";
    }
    $tosay=$_POST["say"];
}
$home_list = array();
$home_list[]=array(
  "body"=>"本文1",
  "nickname"=>"名前1"
);
$home_list[]=array(
  "body"=>"本文2",
  "nickname"=>"名前2"
);
$home_list[]=array(
  "body"=>"本文3",
  "nickname"=>"名前3"
);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="src/index.js"></script>
    <title>サンプルほめ</title>
    <link href="src/style.css" rel="stylesheet" type="text/css" />
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
        <div class="field">
       <input type="hidden" name="speech" id="speech" value = <?php echo($tosay)?> />
       </div>
       <button>再生</button>
      </form>
        
        <?php } ?>

      <script>
        window.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('voice-form');
        const input = document.getElementById('speech');
        form.addEventListener('submit', event => {
        event.preventDefault();
        const toSay = input.value.trim();
        const utterance = new SpeechSynthesisUtterance(toSay);
        speechSynthesis.speak(utterance);
        });
    });
    </script>

    </body>
</html>
