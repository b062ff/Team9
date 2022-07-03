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

function VoiceSlect(num){
        for(i=0;i<actor.length;i++){
                if(num==i)return actor[i];
        }
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
        console.log("成功");
        }
        setCurrentValue(inputElem.value);
}

/**
 * 
 */
 function ToSayAll(size,list){
        console.log("check");
        const toSay = list[0][0];
        const utterance = new SpeechSynthesisUtterance(toSay);
        const voiceselect=VoiceSlect(list[0][3]);
        var i=0;

        for(i=0;i<size;i++){
                toSay = list[i][0];
                utterance = new SpeechSynthesisUtterance(toSay);
                utterance.pitch=list[i][2];
                utterance.voice = speechSynthesis
                        .getVoices()
                        .filter(voice=>voice.name===voiceselect)[0]

        }
 }
   
