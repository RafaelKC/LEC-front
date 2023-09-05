
const form = document.getElementById("form")
const nome = document.getElementById("nome")
const cnpj = document.getElementById("cnpj")
const email = document.getElementById("email")
const mainTelefone = document.getElementById("mainTelefone")
const secondaryTelefone = document.getElementById("secondaryTelefone")
const cep = document.getElementById("cep")
const logradouro = document.getElementById("logradouro")
const numeroEndereco = document.getElementById("numeroEndereco")
const bairro = document.getElementById("bairro")
const cidade = document.getElementById("cidade")
const estado = document.getElementById("Estado")
const senha = document.getElementById("senha")
const confirmarSenha = document.getElementById("confirmarSenha")

form.addEventListener("submit", (ev) => {
    ev.preventDefault();

    validateName()
    validateEmail()
    validatePassword()
    validatePhone()
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
    if((/^\d{10,}$/).test(mainTelefoneValue)) {
        const formItem = mainTelefone.parentElement
        formItem.className = "formInput"
    }else{
        errorInput(mainTelefone, "Insira um telefone válido")
    }
}


function errorInput(input, message){
    const formItem = input.parentElement
    const textMessage = formItem.querySelector("span")

    textMessage.innerText = message

    formItem.className = "formInput error"
}