import { validarCNPJ } from "./utils/validar-cnpj.js";
import { validarTelefone } from "./utils/validar-telefone.js";

const form = document.getElementById("form");
const nome = document.getElementById("nome");
const sobrenome = document.getElementById("sobrenome");
const cnpj = document.getElementById("cnpj");
const email = document.getElementById("email");
const mainTelefone = document.getElementById("mainTelefone");
const secondaryTelefone = document.getElementById("secondaryTelefone");
const cep = document.getElementById("cep");
const logradouro = document.getElementById("logradouro");
const numeroEndereco = document.getElementById("numeroEndereco");
const bairro = document.getElementById("bairro");
const cidade = document.getElementById("cidade");
const estado = document.getElementById("Estado");
const senha = document.getElementById("senha");
const confirmarSenha = document.getElementById("confirmarSenha");

form.addEventListener("submit", (ev) => {
    ev.preventDefault();

    validateName()
    validateSurname()
    validateEmail()
    validatePassword()
    validatePhone()
    confirmPassword()
    validarCnpj()
});

cnpj.addEventListener("input", (ev) => {
    ev.preventDefault();
    maskCnpj(cnpj)
    validarCnpj()
})

nome.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateName()
})

sobrenome.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateSurname()
})

email.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateEmail()
})

senha.addEventListener("input", (ev) => {
    ev.preventDefault();
    validatePassword()
})

mainTelefone.addEventListener("input", (ev) => {
    ev.preventDefault();
    maskPhone(mainTelefone)
    validatePhone()
})

secondaryTelefone.addEventListener("input", (ev) => {
    ev.preventDefault();
    maskPhone(secondaryTelefone)
    validateSecondaryPhone()
})

confirmarSenha.addEventListener("input", (ev) => {
    ev.preventDefault();
    confirmPassword()
})

function validateName(){
    const nomeValue = nome.value

    if(nomeValue === "") {
        errorInput(nome, "Nome é obrigatório.")
    }else{
        const formItem = nome.parentElement
        formItem.className = "formInput"
    }
}

function validateSurname(){
    const sobrenomeValue = sobrenome.value

    if(sobrenomeValue === "") {
        errorInput(sobrenome, "Sobrenome é obrigatório.")
    }else{
        const formItem = sobrenome.parentElement
        formItem.className = "formInput"
    }
}

function validarCnpj(){
    const cnpjValue = cnpj.value

    const valido = validarCNPJ(cnpjValue)
    if (!valido) {
        errorInput(cnpj, "Insira um CNPJ válido." )
    } else {
        const formItem = cnpj.parentElement
        formItem.className = "formInput"
    }
};

function validateEmail() {
    const emailValue = email.value
    if (!emailValue.match(/\w{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,}/)) {
        errorInput(email, "Insira um email válido." )
    }else {
        const formItem = email.parentElement
        formItem.className = "formInput"
    }
}

function validatePassword(){
    const senhaValue = senha.value
    if( senhaValue.length < 8 ||
        !senhaValue.match(/[a-z]/) ||
        !senhaValue.match(/[A-Z]/) ||
        !senhaValue.match(/\d/) ||
        !senhaValue.match(/[^a-zA-z0-9\s]/))
            {
            errorInput(senha, "Insira uma senha válida.")
    }else {
            const formItem = senha.parentElement
            formItem.className = "formInput"
        }
}

function confirmPassword(){
    const senhaC = confirmarSenha.value 
    if(senhaC !== senha.value){
        errorInput(confirmarSenha, "As senhas devem ser iguais")
    }else {
        const formItem = confirmarSenha.parentElement
        formItem.className = "formInput"
    }
}

function validatePhone(){
    const mainTelefoneValue = mainTelefone.value
    if(validarTelefone(mainTelefoneValue)) {
        const formItem = mainTelefone.parentElement
        formItem.className = "formInput"
    }else{
        errorInput(mainTelefone, "Insira um telefone válido")
    }
}

function validateSecondaryPhone(){
    const secondaryTelefoneValue = secondaryTelefone.value
    
    if(validarTelefone(secondaryTelefoneValue) || secondaryTelefoneValue.trim() == "") {
        const formItem = secondaryTelefone.parentElement
        formItem.className = "formInput"
    }else{
        errorInput(secondaryTelefone, "Insira um telefone válido")
    }
}


function errorInput(input, message){
    const formItem = input.parentElement
    const textMessage = formItem.querySelector("span")

    textMessage.innerText = message

    formItem.className = "formInput error"
}

 function maskCnpj(input){ 
    let cnpj = input.value

    if(isNaN(cnpj[cnpj.length - 1]) || cnpj[cnpj.length - 1] == " "){
        input.value = cnpj.substring(0, cnpj.length-1)
        return
     }

     input.setAttribute("maxlength", "18")
     if (cnpj.length == 2 || cnpj.length == 6) {
        input.value += "."
      } else if(cnpj.length == 10) {
          input.value += "/"
      } else if(cnpj.length == 15) {
          input.value += "-"
      }
 }

 function maskPhone(input){ 
    let phone = input.value

    if(isNaN(phone[phone.length - 1]) || phone[phone.length - 1] == " "){
        input.value = phone.substring(0, phone.length-1)
        return
     }

     input.setAttribute("maxlength", "15")
     if (phone.length == 3 ) {
        input.value += ") "
      } else if(phone.length == 10) {
          input.value += "-"
      } else if (phone.length == 1) {
        input.value = "(" + input.value
      } else if(phone.length == 4) {
        var a = phone.substring(0, phone.length-1)
        var b = phone[phone.length - 1]
        input.value = a+") "+b
    } else if(phone.length == 5) {
        var a = phone.substring(0, phone.length-1)
        var b = phone[phone.length - 1]
        input.value = a+" "+b
    } 
 }
 