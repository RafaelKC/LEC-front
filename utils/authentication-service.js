export default class AuthenticationService {
    ESCOLA_TYPE = 'ESCOLA'
    PATROCIONADOR_TYPE = 'PATROCINADOR'

    loggedUser;

    getUserFromStorageAndIfIsLogged() {
        if (this.loggedUser) return this.loggedUser;
        return null;
    }

    setUser(user) {
        this.loggedUser = user;
    }

    logOut() {
        this.loggedUser = null;
        window.localStorage.removeItem(this.USER_STORAGE_KEY);
    }

    convertEscolaInUser(escola) {
        const user =  new User();
        user.type = this.ESCOLA_TYPE
        user.id = escola.id;
        user.nome = escola.nome;
        user.email = escola.email;
        user.idEndereco = escola.idEndereco;
        user.documento = escola.cnpj;

        return user;
    }

    convertPatrocinadoInUser(patrocinador) {
        const user =  new User();
        user.type = this.PATROCIONADOR_TYPE
        user.id = patrocinador.id;
        user.nome = patrocinador.nome;
        user.email = patrocinador.email;
        user.idEndereco = patrocinador.idEndereco;
        user.documento = patrocinador.cnpj ?? patrocinador.cpf;

        return user;
    }

    getUserType() {
        const user = this.getUserFromStorageAndIfIsLogged();
        if (!user) return '';
        return user.type;
    }

    validateIfIsLogger() {
        const user = this.getUserFromStorageAndIfIsLogged();
        return Boolean(user);
    }

    navigaeToHome() {
        window.location.href = "/";
    }
}