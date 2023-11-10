function validateForm() {
    var dataInicio = document.getElementById("dataInicio").value;
    var dataFim = document.getElementById("dataFim").value;

    if (dataInicio === "" || dataFim === "") {
        alert("Por favor, preencha todas as datas.");
        return false;
    }

    return true;
}