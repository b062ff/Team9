<?php 

error_reporting(E_ALL);              // エラー出力のレベルを設定します
ini_set("display_errors", "On");     // 画面上にエラー出力を表示する設定にします
$error_message = array();
$tosay =array();
// 変更：MySQLに接続する
$mysqli = new mysqli("localhost", "root", "", "home");
$PageNum=2;


//投稿されたときの処理(DBに保存)
if(isset($_POST["save"])){
    $PageNum=$_POST["page"];
    if(!strlen($_POST["body"])){
        $error_message[]="本文を入力してください。";
    }
    if($_POST["pich"]==NULL){
        $error_message[]="ピッチを入力してください。";
    }
    if(!count($error_message)){
        $stmt = $mysqli->prepare("INSERT INTO post (body,pich,VoiceType,Situation) VALUES (?, ?,?,?)");     // 変更
        $stmt->bind_param("ssss",$_POST["body"],$_POST["pich"],$_POST["VoiceType"],$_POST["Situation"]);
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


if(isset($_POST["SelectHome"])){
    $VT=$_POST["VoiceType"];
    $ST=$_POST["Situation"];
    $PageNum=$_POST["page"]+1;
    if(!count($error_message)){
        $sql = "SELECT * FROM post WHERE VoiceType=$VT AND Situation=$ST";
        echo($sql);     // 変更
        $result = $mysqli->query("$sql");
        $home_list = array();
        while ($home = $result->fetch_array()) {      // 変更
        $home_list[] = $home;                        // 変更
        } 
    }
    
}


if(isset($_POST["next"])){
    $PageNum=$_POST["page"]+1;
}
if(isset($_POST["back"])){
    $PageNum=$_POST["page"]-1;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script  type="text/javascript" src="src/index.js" charset="utf-8"></script>
    <title>ほめstart</title>
    </head>
    <body>
    <?php if($error_message){
          foreach($error_message as $error){
              echo($error);
          }
      }
      ?>


        <?php
        if($PageNum==2){
            echo("start your engine");?>
            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <input type="hidden" name= "page" value=2>
            <input name="next" type="submit" value="ほめられる">
            <input name="back" type="submit" value="ほめる">
            </form>
        <?php } ?>
        <?php
        if($PageNum==1){
            echo("投稿");?>
            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <input type="hidden" name= "page" value=1>
            <table>
                <tr colspan="2">
                    <th>ほめてみよう</th>
                    <td colspan="2"><textarea name="body" cols="50" rows="5"></textarea></td>
                </tr>
                <tr>
                    <th>ピッチ</th>
                    <td><input type="number" name ="pich",value="1",step="0.1",min="-2",max="2"></td>
                </tr>
                <select name="VoiceType">
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                </select>
                <select name="Situation">
                    <option value="1">クール</option>
                    <option value="2">可愛い</option>
                </select>
            </table>
            <input name="save" type="submit" value="投稿する">
            <input name="next" type="submit" value="戻る">
            </form>
        <?php } ?>
        <?php
        if($PageNum==3){
            echo("ジャンル");?>
            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <select name="VoiceType">
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                </select>
                <select name="Situation">
                    <option value="1">クール</option>
                    <option value="2">可愛い</option>
            </select>
            <input type="hidden" name= "page" value=3>
            <input name="SelectHome" type="submit" value="スタート">
            <input name="back" type="submit" value="戻る">
            </form>
        <?php } ?>
        <?php
        if($PageNum==4){
            echo("再生");?>

            <?php foreach($home_list as $home){ ?>
                <h4> <?php echo($home["body"]);?></h4>       
                <form id="voice-form"> 
                    <input type="hidden" name="speech" id="speech" value = <?php echo($home["body"])?> />
                    <input type="button" class="circlebutton" value="再生" onclick="ToSayClick();"/>
                </form>
            <?php } ?>

            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <input type="hidden" name= "page" value=4>
            <input name="back" type="submit" value="戻る">
            </form>
        <?php } ?>
        


    </body>
</html>