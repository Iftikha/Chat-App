document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('.message-form');
    const send_btn = form.querySelector('.send-btn');
    const chatbox = document.querySelector('.msgs');

// Send message
form.onsubmit = (e) => {
    e.preventDefault();
};

send_btn.onclick = () => {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'assets/utils/send_message.php', true);
    xhr.onload = () => {
        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
            form.querySelector('#text-msg').value = "";
            scrollToBottom();
        }
    };
    const formData = new FormData(form);
    xhr.send(formData);
};

// Fetch messages
function fetchMessages(){
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "assets/utils/get_message.php", true);

    xhr.onload = () => {
        if(xhr.status === 200){
            chatbox.innerHTML = xhr.responseText;
            scrollToBottom();
        }
    };

    const formData = new FormData(form);
    xhr.send(formData);
}

setInterval(fetchMessages, 1000); // Refresh every 1 sec

function scrollToBottom(){
    chatbox.scrollTop = chatbox.scrollHeight;
}
});