//getVoice()のバグで一回読み込み時に空の配列を返すので、二回getVoices()を行う
var voices = speechSynthesis.getVoices();
//使う声を限定
var  actor=new Array(
        "Microsoft Ayumi - Japanese (Japan)",
        "Microsoft Sayaka - Japanese (Japan)",
        "Microsoft Haruka - Japanese (Japan)",
        "Microsoft Aria Online (Natural) - English (United States)",
        "Microsoft Ichiro - Japanese (Japan)",
        "Microsoft Guy Online (Natural) - English (United States)"
        );
//ボイステキスト
var  textTalk=new Array();
var Pitch_list=new Array();
var pastTalk_list=new Array();
var Voice=0;
var waitID=10;

function VoiceSlect(num){
        for(i=0;i<actor.length;i++){
                if(num==i)return actor[i];
        }
}
var countTimes=0;
function waitTest(){
        
        printText(countTimes);
        ToSayText(countTimes,Voice);
        printPastText(countTimes);
        startAnime();
        countTimes++;

        clearTimeout(waitID);
        if(countTimes<textTalk.length){
                waitID=setTimeout(waitTest,8000);
        }
}
//ボタンを押したときにスタート
function Starttest(){
        countTimes=0;
        setTimeout(waitTest,2000);
        
}
//配列をtextTalk[],Pitch_list[]に代入
function LoadArray(js_array,ph_array,vict){
        Voice=vict;
        var count=js_array.length;
        for(var i=0;i<count;i++){
                textTalk[i]=js_array[i];
                Pitch_list[i]=ph_array[i];
        }
}
//textTalk[]のi番目の要素をdiv textIDに表示
function printText(i){
        var texthtml = document.getElementById("textID");
        texthtml.innerHTML=textTalk[i];
}
//過去の発言を表示 
function printPastText(countTimes){
        if(countTimes!=0){
                var newPast= document.createElement("div");
                newPast.innerHTML=textTalk[countTimes-1];
                newPast.setAttribute("class","messa");
                document.getElementById("past").appendChild(newPast);
                const tdiv = document.getElementById("past");
                tdiv.scrollTop = tdiv.scrollHeight;
        }

}

/**
 * num:配列の要素番目
 * v:声の種類
 */
 function ToSayText(num,v){
        const toSay = textTalk[num];
        const utterance = new SpeechSynthesisUtterance(toSay);
        const voiceselect=VoiceSlect(v);

        utterance.pitch=Pitch_list[num];
        utterance.voice = speechSynthesis
                .getVoices()
                .filter(voice=>voice.name===voiceselect)[0]

        speechSynthesis.speak(utterance);
}
/**
 * アニメーションをする。
 */
function startAnime(){
        document.getElementById("submitBtn").click();
}

/**
 * ボタンが押されたときに発言
 * num:声の種類
 * Pitch:ピッチの大きさ(0.0~2.0)
 * speech:話す内容
 */
function ToSayClick(num,Pitch,speech){
        const toSay = speech;
        const utterance = new SpeechSynthesisUtterance(toSay);
        const voiceselect=VoiceSlect(num);

        utterance.pitch=Pitch;
        utterance.voice = speechSynthesis
                .getVoices()
                .filter(voice=>voice.name===voiceselect)[0]

        speechSynthesis.speak(utterance);
}
/**
 * スライダーの値が変更されたときの表示
 * inputElem
 * currentValueElem
 * 
 */

function printValue(){
        const inputElem = document.getElementById("Range");
        const currentValueElem = document.getElementById("current-value");

        //現在の値をspanに組み込む関数
        const setCurrentValue = (val)=>{
        currentValueElem.innerText = val;
        }
        //inputイベント時に値をセットする関数
        const rangeOnCharge = (e) =>{
        setCurrentValue(e.target.value);
        }
        setCurrentValue(inputElem.value);
}

