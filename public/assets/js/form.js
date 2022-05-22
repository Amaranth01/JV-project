let password = document.querySelector('#password');
let passwordRepeat = document.querySelector('#passwordR');
let username = document.querySelector('#username');
let email = document.querySelector('#email');
let emailRepeat = document.querySelector('#emailR');
let message = document.querySelector('.message');

//validate password
function validatePassword() {
    if(password !== passwordRepeat) {
        message = 'Les mots de passe ne correspondent pas';
    } else {
        return true;
    }

    if(password.value.length < 6 && password.value.length > 50) {
        password.style.background = 'red';
        passwordRepeat.style.background = 'red'
        message = 'Le mot de passe doit faire au moins 6 caractères et 50 maximum';
    } else {
        return true;
    }
}

//ValidateEmail
function validateEmail () {
    if(email !== emailRepeat) {
        message = 'Les emails ne correspondent pas';
        return false;
    } else {
        return true;
    }
}

//verification if input are empty
function validateForm() {
    if (username === '' ) {
        message ='Veuillez remplir le champ de votre pseudo';
    }
    if(username === true) {
        message = 'ce pseudo existe déjà';
    }

    if(email && emailRepeat === '') {
        message ='Veuillez inscrire votre email dans les deux champs';
    }

    if(password && passwordRepeat === '') {
        message ='Veuillez inscrire votre mot de passe dans les deux champs';
    }
}
validatePassword();
validateEmail();
validateForm();