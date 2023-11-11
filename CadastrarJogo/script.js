let idCampeonato = '';
let idTemporada = '';

function setInputsPrecadastro() {
    const inputCamepeonato = document.getElementById('campeonatoInput')
    idCampeonato = inputCamepeonato.value;
    const inputTemporada = document.getElementById('temporadaInput')
    idTemporada = inputTemporada.value;
    const currentPath = window.location.pathname;
    window.location.href = `${currentPath}${getParameters()}`;
}

function getParameters() {
    const campeonatoParams =  `idCampeonato=${idCampeonato}`;
    const temporadaParams =  `idTemporada=${idTemporada}`;

    let final = '';
    if (idCampeonato != null || idTemporada != null) {
        final += '?';

        if (idCampeonato != null) {
            final += campeonatoParams
            if(idTemporada) {
                final += '&';
                final += temporadaParams;
            }
        } else if(idTemporada) {
            final += temporadaParams;
        }
    }

    return final;
}