let password = document.querySelector('#password');
let passwordRepeat = document.querySelector('#passwordR');
let username = document.querySelector('#username');
let email = document.querySelector('#email');
let emailRepeat = document.querySelector('#emailR');
let buttonForm = document.querySelector('#buttonForm');

buttonForm.addEventListener('click', function(){
    if(email.value === "" && username.value === "" && password.value === "" && passwordRepeat.value === "" && emailRepeat.value === "") {
        let div = document.createElement('div');
        div.innerHTML = "Merci de remplir tous les champs."
        div.style.background = 'red';
        div.style.color = 'white';
    }
});