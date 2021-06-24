const changePassword = () => {
    const password = document.getElementById("lastPassword").value;
    const newPassword = document.getElementById("newPassword").value;
    const confirmNewPassword = document.getElementById("confirmNewPassword").value;
    const login = sessionStorage.getItem("user");

    const table = "musuarios";
    const postType = "ChangePassword";

    let sqlSelect = `SELECT * FROM ${table} WHERE Login = '${login}' AND Password = '${password}'`;
    let sqlUpdatePass = `UPDATE ${table} SET Password = '${newPassword}' WHERE Login = '${login}'`;

    let data = {
        postType,
        sqlSelect,
        sqlUpdatePass,
        password,
        newPassword,
        confirmNewPassword
    }
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data,// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            let message = document.getElementById("message");
            if (resp === "Contraseña actualizada") {
                message.style.color = "green";
                message.innerText = resp;
                setTimeout(() => {
                    window.location.href = "../";
                    sessionStorage.clear();
                }, 2000)
            } else {
                message.style.color = "red";
                message.innerText = resp;
            }
            setTimeout(() => {
                message.style.color = "";
                message.innerText = "";
            }, 2500)

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log("erro: ", errorThrown);
        }
    });


}