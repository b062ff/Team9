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
function ToSayClick(num,Pitch,speech){
        const toSay = speech;
        const utterance = new SpeechSynthesisUtterance(toSay);
        const voiceselect=VoiceSlect(num);

        utterance.pitch=Pitch;

        utterance.voice = speechSynthesis
                .getVoices()
                .filter(voice=>voice.name===voiceselect)[0]

        utterance.pich=0.0;
        speechSynthesis.speak(utterance);
}