const nome = document.getElementById("campeonatoNome");

form.addEventListener("submit", (ev) => {
    const nameValid = validateName()

    const formVald = nameValid 

    if (!formVald) {
        ev.preventDefault();
    }
});

nome.addEventListener("input", (ev) => {
    ev.preventDefault();
    validateName()
})


function validateName(){
    const nomeValue = nome.value

    if(nomeValue === "") {
        errorInput(nome, "Nome é obrigatório.")
        return false
    }else{
        const formItem = nome.parentElement
        formItem.className = "formInput"
        return true
    }
}

function errorInput(input, message){
    const formItem = input.parentElement
    const textMessage = formItem.querySelector("span")

    textMessage.innerText = message

    formItem.className = "formInput error"
}