//#region  utilitários

//função para eventos em um elemento
function elementEvent(id, event, callback){
    var element = document.getElementById(id);
    if(element !== null){
        element.addEventListener(event, callback);
    }
}

//#endregion

//#region eventos formulários

//validção entre o campo senha e o de confirmção de senha
function checkPassword(){
    var password = document.getElementById("password_signin").value;
    var confirmPassword = document.getElementById("password_confirm_signin").value;
    var message = document.getElementById("password_error");
    var submitBtn =  document.getElementById("submit_sigin");

    if(password != confirmPassword &&
        confirmPassword != "")
    {
        message.classList.remove("hidden");
        submitBtn.classList.add("btn-disabled");
        submitBtn.disabled = true;
    }else{
        message.classList.add("hidden");
        submitBtn.classList.remove("btn-disabled");
        submitBtn.disabled = false;
    }
}

//alterar o formulário ativo na landing page
function activeLoginForm(){
    document.getElementById("signin_form").classList.add("hidden");
    document.getElementById("login_form").classList.remove("hidden");
}

function activeSigninForm(){
    document.getElementById("signin_form").classList.remove("hidden");
    document.getElementById("login_form").classList.add("hidden");
}

//ativar o dislpay do formulário de filtros na userpage
function showFilters(){
    var btnText = document.getElementById("filter_btn").textContent;
    if(btnText == "Mostrar Filtros"){
        document.getElementById("filter_btn").textContent = "Fechar Filtros";
    }else{
        document.getElementById("filter_btn").textContent = "Mostrar Filtros";
    }
    document.getElementById("filter_form").classList.toggle("hidden");
}

//confirma a exclusão de uma tarefa
function confirmDelete(form, type){
    //alerta para a exclusão de uma tarefa
    if(type == 0){
        createAlert(ALERT_TYPE.DELETE, "Aviso!", "Tem certeza que deseja excluir essa tarefa?");
    }

    //alerta para a exclusão de conta
    if(type == 1){
        createAlert(ALERT_TYPE.DELETE, "Aviso!", "Tem certeza que deseja excluir sua conta?");
    }

    elementEvent("delete_btn", "click", () => {
        form.submit();
    });
}

//habilita ou desabilita os detalhes do usuário
function showUserdetails(){
    document.getElementById("user_details").classList.toggle("user-disable");
}

//realiza o logout do usuário da página
function logout(){
    window.location.href = "logout.php";
}

//#endregion

//#region alerta customizado

//enum para os tipos de alerta
const ALERT_TYPE = {
    OK: 0,
    DELETE: 1
};

//criar alertas customizados
function createAlert(type, title, desc, callback){
    var alertTitle = document.getElementById("alert_title");
    alertTitle.textContent = title;

    var alertSub = document.getElementById("alert_subtitle");
    alertSub.textContent = desc;

    var overlay =  document.getElementById("overlay");
    overlay.classList.remove("hidden");

    var alert =  document.getElementById("alert");
    alert.classList.remove("hidden");

    switch(type){
        //ok alert
        case(ALERT_TYPE.OK):
            document.getElementById("ok_btn").classList.remove("hidden");
        break;

        case(ALERT_TYPE.DELETE):
            document.getElementById("cancel_btn").classList.remove("hidden");
            document.getElementById("delete_btn").classList.remove("hidden");
        break;
    }
}

//fechar um alerta
function closeAlert(){
    var overlay =  document.getElementById("overlay");
    overlay.classList.add("hidden");

    var alert =  document.getElementById("alert");
    alert.classList.add("hidden");

    document.getElementById("ok_btn").classList.add("hidden");
    document.getElementById("cancel_btn").classList.add("hidden");
    document.getElementById("delete_btn").classList.add("hidden");
}

//#endregion

//#region document

//listeners
document.addEventListener("DOMContentLoaded", () => {
    //redirecionando para o formulário desejado
    elementEvent("signin_change_link", "click", activeLoginForm);
    elementEvent("login_change_link", "click", activeSigninForm);

    //checagem de senha
    elementEvent("password_confirm_signin", "keyup", checkPassword);

    //alerta customizado
    elementEvent("ok_btn", "click", closeAlert);
    elementEvent("cancel_btn", "click", closeAlert);

    //ativando o menu de filtros
    elementEvent("filter_btn", "click", showFilters);

    //ativando o menu de usuário
    elementEvent("user_btn", "click", showUserdetails);

    //logout do usuário
    elementEvent("logout_btn", "click", logout);
});

//verificando erros ao carregar a página
window.onload = (e) => {
    const url = window.location.search;
    const urlParams = new URLSearchParams(url);
    var error = urlParams.get("error");
    var success = urlParams.get("success");

    //nome de usuário indisponível ao cadatrar
    if(error == "username_not_avaiable"){
        createAlert(ALERT_TYPE.OK, "Aviso!", "Nome de usuário indisponível");
        activeSigninForm();
    }

    //usuário ou senha incorretos no login
    if(error == "wrong_username_or_password"){
        createAlert(ALERT_TYPE.OK, "Aviso!", "Usuário ou senha incorretos");
        activeLoginForm();
    }

    //tarefa criada com sucesso
    if(success == "task_created"){
        createAlert(ALERT_TYPE.OK, "Pronto!", "Tarefa criada com sucesso");
    }

    //tarefa modificada com sucesso
    if(success == "task_edited"){
        createAlert(ALERT_TYPE.OK, "Pronto!", "Tarefa modificada com sucesso");
    }

    //tarefa excluida com sucesso
    if(success == "task_deleted"){
        createAlert(ALERT_TYPE.OK, "Pronto!", "Tarefa excluída com sucesso");
    }

    //removendo o erro da url após seu precessaomento
    urlParams.delete("error");
    urlParams.delete("success");
    window.history.replaceState(
        {},
        '',
        `${window.location.pathname}?${urlParams}${window.location.hash}`,
    );
}

//#endregion
