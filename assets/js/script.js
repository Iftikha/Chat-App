function toggleMenu() {
        document.getElementById("menu").classList.toggle('hidden');
};
function modalToggle() {
        document.getElementById("changePfpForm").classList.toggle('hidden');        
};
function toggleModal(str) {
        document.getElementById("changeUsernameForm").classList.toggle('hidden');
        console.log(str);
        document.getElementById('c_username').value = str;   
};

