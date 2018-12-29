$("form").submit(function(e){
    var newPass = $("#new_pass").val();
    var confirmNewPass = $("#new_pass_confirm").val();

    var errMsg = document.createElement("div");
    errMsg.className += "alert";
    errMsg.className += " alert-danger";
    errMsg.className += " mt-1";
    errMsg.setAttribute("role", "alert");

    if (newPass !== confirmNewPass) {
        errMsg.innerHTML = "<strong>As senhas digitadas não conferem</strong>";
        $("h1").after(errMsg);
        e.preventDefault();
        return;
    }
});