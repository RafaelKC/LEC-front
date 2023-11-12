const beginDate = document.getElementById("dataInicio");
const endDate = document.getElementById("dataFim");

form.addEventListener("submit", (ev) => {
  validateBeginDate();
  validateEndDate();
});

beginDate.addEventListener("input", (ev) => {
  ev.preventDefault();
  validateBeginDate();
});

endDate.addEventListener("input", (ev) => {
  ev.preventDefault();
  validateEndDate();
});

function validateBeginDate() {
  const beginDateValue = beginDate.value;

  if (beginDateValue === "") {
    errorInput(beginDate, "Data de nascimento é obrigatório.");
  } else {
    const formItem = beginDate.parentElement;
    formItem.className = "formInput";
  }
}

function validateEndDate() {
  const endDateValue = endDate.value;

  if (endDateValue === "") {
    errorInput(endDate, "Data de nascimento é obrigatório.");
  } else {
    const formItem = endDate.parentElement;
    formItem.className = "formInput";
  }
}

function errorInput(input, message) {
  const formItem = input.parentElement;
  const textMessage = formItem.querySelector("span");

  textMessage.innerText = message;

  formItem.className = "formInput error";
}
