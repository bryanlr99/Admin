const ValidLogin = () => {
    const login = document.getElementById("login").value;
    const password = document.getElementById("password").value;
    const table = "musuarios";
    const postType = "ValidLogin";
    let sqlSelect = `SELECT * FROM ${table} WHERE Login = '${login}' AND Password = '${password}'`;

    let data = {
        postType,
        table,
        sqlSelect,
        login,
        password,
    }
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "server.php", // URL a la que estamos haciendo el request
        data,// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            console.log(resp);
            if (resp.split(",")[0] === "Fecha en rango") {

                window.location.href = "./home"
                sessionStorage.setItem("login", "true");
                sessionStorage.setItem("user", login);
                sessionStorage.setItem("cvUser", resp.split(",")[1]);
                sessionStorage.setItem("idCatRel", resp.split(",")[2]);
                sessionStorage.setItem("fechaActual", resp.split(",")[3]);

            } else {
                document.getElementById("message").innerText = resp;
                sessionStorage.setItem("login", "false");
            }
            setTimeout(() => {
                document.getElementById("message").innerText = "";
            }, 2500)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log("erro: ", errorThrown);
        }
    });
}
