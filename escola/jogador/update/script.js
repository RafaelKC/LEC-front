const form = document.getElementById("form");
const nome = document.getElementById("nome");
const sobrenome = document.getElementById("sobrenome");

form.addEventListener("submit", (ev) => {

  validateName();
  validateSurname();
  validateShirtNumber();
  validateNickname();
});

nome.addEventListener("input", (ev) => {
  ev.preventDefault();
  validateName();
});


sobrenome.addEventListener("input", (ev) => {
  ev.preventDefault();
  validateSurname();
});


function validateName() {
  const nomeValue = nome.value;

  if (nomeValue === "") {
    errorInput(nome, "Nome é obrigatório.");
  } else {
    const formItem = nome.parentElement;
    formItem.className = "formInput";
  }
}

function validateSurname() {
  const sobrenomeValue = sobrenome.value;

  if (sobrenomeValue === "") {
    errorInput(sobrenome, "Sobrenome é obrigatório.");
  } else {
    const formItem = sobrenome.parentElement;
    formItem.className = "formInput";
  }
}

function validateShirtNumber() {
  const shirtNumberValue = document.getElementById("nmrCamisa").value;

  // Verifica se o número da camisa é um número válido
  if (
    isNaN(shirtNumberValue) ||
    shirtNumberValue < 1 ||
    shirtNumberValue > 99
  ) {
    errorInput(
      document.getElementById("nmrCamisa"),
      "Número da camisa inválido. Deve ser entre 1 e 99."
    );
  } else {
    // Se passar no teste acima, remove a mensagem de erro
    clearError(document.getElementById("nmrCamisa"));
  }
}

function validateNickname() {
  const nicknameValue = document.getElementById("nomeDeJogo").value;

  // Verifica se o campo de nome de jogo não está vazio
  if (nicknameValue.trim() === "") {
    errorInput(
      document.getElementById("nomeDeJogo"),
      "Nome de jogo é obrigatório."
    );
  } else {
    // Se passar no teste acima, remove a mensagem de erro
    clearError(document.getElementById("nomeDeJogo"));
  }
}

function clearError(input) {
  const formItem = input.parentElement;
  const textMessage = formItem.querySelector("span");

  textMessage.innerText = "";
  formItem.className = "formInput";
}

function errorInput(input, message) {
  const formItem = input.parentElement;
  const textMessage = formItem.querySelector("span");

  textMessage.innerText = message;

  formItem.className = "formInput error";
}
