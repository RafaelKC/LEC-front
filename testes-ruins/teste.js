// function validateName(nome) {
//     if(!nome) {
//        const err = new Error('Insira um nome.')
//        err.input = 'nome'
//        throw err
//     }
// }

// function validateCnpj(cnpj) {

// }


// function validateEmail(email) {
//     if (!email.match(/\w{2,}@[a-zA-Z]{2,}\.[a-zA-Z]{2,}/)) {
//         const err = new Error('Email inválido.')
//         err.input = 'email'
//         throw err
//     }
// }



// function validatePhone(mainTelefone){
//     if(mainTelefone !== 'number'){
//         const err = new Error('Telefone inválido insira números')
//         err.input = 'mainTelefone'
//         throw err
//     }



// }



// function validatePassword(senha){
//     if (
//         senha.length < 8 ||
//         !senha.match(/[a-z]/) ||
//         !senha.match(/[A-Z]/) ||
//         !senha.match(/\d/) ||
//         !senha.match(/[^a-zA-z0-9\s]/)
//     )
//     {
//         const err = new Error('Senha inválida.')
//         err.input = 'senha'
//         throw err
//     }
// }

// function confirmPassword(confirmarSenha){
//     if(userInputs.senha !== confirmarSenha){
//         const err = new Error('As senhas devem ser iguais.')
//         err.input = 'confirmarSenha'
//         throw err
//     }
// }


// function resetFormStyles() {
//     Object.entries(userInputs).forEach(([key, value]) => {
//         value.classList.remove('success', 'error')
//         document.querySelector(`#${key}-error`).textContent = ''
//     })
// }

// const form = document.querySelector('form')



// const userInputs = {}
    

//     userInputs.name = document.querySelector('#nome'),
//     userInputs.email = document.querySelector('#email'),
//     userInputs.senha = document.querySelector('#senha'),
//     userInputs.confirmarSenha = document.querySelector('#confirmarSenha')



// form.addEventListener('submit', (ev) => {
//     ev.preventDefault()
//     resetFormStyles()
//     try {
//         validateName(userInputs.name.value)
//         userInputs.name.classList.add('success')
//         validateEmail(userInputs.email.value)
//         userInputs.email.classList.add('success')
//     } catch (err) {
//         userInputs[err.input].classList.add('error')
//         document.querySelector(`#${err.input}-error`).textContent = err.message
//     }
// }) 