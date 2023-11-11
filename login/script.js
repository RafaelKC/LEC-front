import AuthenticationService from '../utils/authentication-service.js'

const authenticationService = new AuthenticationService();

function validateIfIsLogged() {
    if (authenticationService.validateIfIsLogger()) {
        authenticationService.navigaeToHome();
    }
}

validateIfIsLogged();


const form = document.getElementById("form");
const senha = document.getElementById("senha");
const email = document.getElementById("email");

form.addEventListener("submit", (ev) => {
    const emailValid = validateEmail()
    const senhalValid = validateSenha()

    const formVald = senhalValid && emailValid;

    if (!formVald) {
        ev.preventDefault();
    }
});

email.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateEmail()
})

senha.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateSenha()
})

function setAllFail() {
    errorInput(email, "Email ou senha Inválidos." )
    errorInput(senha, "Email ou senha Inválidos." )
}

function validateEmail() {
    const emailValue = email.value
    if (!emailValue.match(/\w{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,}/)) {
        errorInput(email, "Insira um email válido." )
        return false
    }else {
        const formItem = email.parentElement
        formItem.className = "formInput"
        return true
    }
}

function validateSenha(){
    const senhaValue = senha.value
    if(!Boolean(senhaValue))
    {
        errorInput(senha, "Insira uma senha válida.")
        return false
    }else {
        const formItem = senha.parentElement
        formItem.className = "formInput"
        return true
    }
}
