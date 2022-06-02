import "./styles.css";

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
