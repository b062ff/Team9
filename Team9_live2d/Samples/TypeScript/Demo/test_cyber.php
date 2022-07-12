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
    if(!isset($_POST["VoiceType"])){
        $error_message[]="声の種類を選択してください。";
    }
    if(!isset($_POST["Situation"])){
        $error_message[]="シチュエーションを選択してください。";
    }
    if(!strlen($_POST["body"])){
        $error_message[]="本文を入力してください。";
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
        $i=count($home_list)-1;
        while($i>0){
            $j=rand()%($i+1);
            $tmp=$home_list[$j];
            $home_list[$j] =$home_list[$i];
            $home_list[$i]=$tmp;
            $i--;
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
    <link href="src/style.css" rel="stylesheet" type="text/css" />
    <link href="src/cyberpunk-2077.css" rel="stylesheet" type="text/css" />
    <script  type="text/javascript" src="src/index.js" charset="utf-8"></script>
    <title>ほめstart</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <!-- Pollyfill script -->
    <script src="https://unpkg.com/core-js-bundle@3.6.1/minified.js"></script>
    <!-- Live2DCubismCore script -->
    <script src = "../../../Core/live2dcubismcore.js"></script>
    <!-- Build script -->
    <script src = "./src/bundle.js"></script>
</head>

<body>
    <?php if($error_message){?>
        <p class="cyberpunk inverse scannedv">
            <?php 
                foreach($error_message as $error){
                echo($error);
                echo("<br>");
                }
            ?>
        </pz>
    <?php }?>


    <?php
        if($PageNum==2){
            echo("start your engine");?>
            <form method="post" style="text-align:center" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <input type="hidden" name= "page" value=2>
            <p>
                <button type="submit" name="next"id="Btn1" class ="cybr-btn">Be praised<span aria-hidden>_</span>
                <span aria-hidden class="cybr-btn__glitch">Be Praised</span>
                <span aria-hidden class="cybr-btn__tag">R04</span>
                </button>
            </p>
            <p> <button type="submit" name="back" id=" Btn2" class ="cybr-btn" margin="50px">Praise<span aria-hidden>_</span>
                <span aria-hidden class="cybr-btn__glitch">Praise</span>
                <span aria-hidden class="cybr-btn__tag">R05</span>
                </button>
            </p>


            </form>
        <?php } ?>
        
        <?php if($PageNum==1){?>
            <form method="post"  action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <div style="text-align:center">
            <input type="hidden" name= "page" value=1>
            <h3 class="cyberpunk">Voice Type</h3>
            <p>
                <div class="cp_ipselect">
                <select class="cp_sl02" required name="VoiceType">
                <option value="0" hidden disabled selected></option> 
                    <option value="0">WomanA</option>
                    <option value="1">WomanB</option>
                    <option value="2">WomanC</option>
                    <option value="3">WomanD(only English)</option>
                    <option value="4">ManA</option>
                    <option value="5">ManB(only English)</option>
                </select><span class="cp_sl02_highlight"></span><span class="cp_sl02_selectbar"></span><label class="cp_sl02_selectlabel">select voice</label>
            </div>
            </p>
            <h3 class="cyberpunk glitched">Sitiuation</h3>
            <p>
                <div class="cp_ipselect">
                    <select class="cp_sl02" required name="Situation">
                    <option value="1" hidden disabled selected></option> 
                    <option value="1">Cool</option>
                    <option value="2">Cute</option>
                    </select><span class="cp_sl02_highlight"></span><span class="cp_sl02_selectbar"></span><label class="cp_sl02_selectlabel">select situation</label>
                </div>
            </p>

            <h3 class="cyberpunk">Pitch</h3>
            <p> <input type="range" min='0' max='2' name ="pich" id="Range" value='1' step="0.1" oninput="printValue();"></p>            
                <p>ピッチの大きさ=<span id ="current-value">1</span></p>   
                <h3 class="cyberpunk glitched">Message</h3>
                <p><textarea name="body" cols="50" rows="5"></textarea> </p>
                <p><button name="save" type="submit">投稿する</button>
                </div>  
                <p><button name="next" type="submit"  class="cyberpunk2077 green">戻る</button></p>
            </form> 
            
        <?php } ?>
        <?php
        if($PageNum==3){
            echo("ジャンル");?>
            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            
            <div style="text-align:center">
            <p>
            <select name="VoiceType">
                    <option value="0">女性A</option>
                    <option value="1">女性B</option>
                    <option value="2">女性C</option>
                    <option value="3">女性D(only English)</option>
                    <option value="4">男性A</option>
                    <option value="5">男性B(only English)</option>
                </select>
                <p><select name="Situation">
                    <option value="1">クール</option>
                    <option value="2">可愛い</option>
                </select></p>
                <p>
                    <input type="hidden" name= "page" value=3>
                    <button name="SelectHome" id="Btn2" type="submit">スタート</button>
                </p>
            </div>
            <button name="back" type="submit" class="cyberpunk2077 green">戻る</button>
            </form>
        <?php } ?>
        <?php
        if($PageNum==4){
            echo("再生");?>
            <div id="live2d_canvas" style="text-align:center" ></div>
            <?php foreach($home_list as $home){ ?>
                <div class="messa" style="text-align:center">
                <?php echo($home["body"]);?>
                </div>
                <form id="voice-form"> 
                    <?php  
                    $speech=$home["body"]; 
                    $Pitch = $home["pich"];
                    ?>
                    <input type="button" class="circlebutton" value="再生"  id="submitBtn" v-on:click="submit" :disabled="!isWork" onclick="ToSayClick(<?php echo($VT); ?>,<?php echo($Pitch); ?>,'<?php echo($speech); ?>');"/>
                </form>
            <?php } ?>
            <form method="post" action="<?php echo($_SERVER["SCRIPT_NAME"])?>">
            <input type="hidden" name= "page" value=4>
            <button name="back" type="submit" class="cyberpunk2077 green">戻る</button>
            </form>
        <?php } ?>
    </body>
</html>