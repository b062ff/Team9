function ToSayClick(){
        const form = document.getElementById('voice-form');
        const input = document.getElementById('speech');
        const toSay = input.value.trim();
        const utterance = new SpeechSynthesisUtterance(toSay);
        speechSynthesis.speak(utterance);
}
