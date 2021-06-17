let deleteNode;
$(document).ready(() => {
    const currentDate = getCurrentDate(); debugger
    document.getElementById("FechaIni").value = currentDate
    document.getElementById("FechaFin").value = addDaysToDate(5, currentDate)
    getDataTables();
    sessionStorage.setItem("cambioColor", "false");
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType: "fillSelect",
            table: "catreluserinformation"
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            // console.log(resp)
            let array = JSON.parse(resp);
            let option = "";
            for (let i = 0; i < array.length; i++) {
                option += `<option value='${array[i]["IdCatRel"]}'>${array[i]["Nombres"]} ${array[i]["ApellidoPat"]} ${array[i]["ApellidoMat"]}</option>`;
            }
            $("#Nombres").append(option)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });

})

const inputs = ["Nombres", "Login", "Password", "FechaIni", "FechaFin", "EdoCta"];
const getDataTables = () => {

    const table = "musuarios";
    const postType = "queryGetTables";

    let data = {
        postType,
        table
    }
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data,// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            console.log("resp", resp.split("|")[1])
            if (resp.split("|")[0] !== "solo columnas") {
                let data = JSON.parse(resp.split("|")[1]);
                // sessionStorage.setItem("data", JSON.stringify(data));
                let tHeader = Object.keys(data[0]);
                // sessionStorage.setItem('theader', JSON.stringify(tHeader));

                let tr = "";
                let th = "";
                let td = "";
                for (let h = 0; h < tHeader.length; h++) {
                    if (h === 0 || h === 1) {
                        th += `<th style="display:none">${tHeader[h]}</th>`;
                    } else if (tHeader[h] === "Password") {
                        th += `<th style="display:none">${tHeader[h]}</th>`;
                    } else if (tHeader[h] !== "CvNombre") {

                        th += `<th>${tHeader[h]}</th>`;
                    }
                }
                // th += `<th>Acción</th>`;
                tr = `<tr contenteditable="false">${th}</tr>`
                for (let col = 0; col < data.length; col++) {
                    for (let key = 0; key < tHeader.length; key++) {
                        if (key === 0 || key === 1) {
                            td += `
                            <td contenteditable="false" style="display:none">
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                        } else if (tHeader[key] === "Password") {
                            td += `
                            <td contenteditable="false" style="display:none">
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="input_${data[col][tHeader[0]]}_${data[col][tHeader[1]]} hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                        } else {
                            // let auxCol = tHeader[key] === "Nombre" ? data[col][tHeader[1]] : tHeader[key];debugger
                            td += `
                            <td contenteditable="false">
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="input_${data[col][tHeader[0]]}_${data[col][tHeader[1]]} hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                        }
                        // if ((key + 1) === tHeader.length) {
                        //     td += `
                        //     <td contenteditable="false">                        
                        //         <img id="${tHeader[0]}_${data[col][tHeader[0]]}" class="delete_${data[col][tHeader[0]]} imagesStyle" src="../images/eliminar.png" alt="" onClick="deleteRegister(this)">
                        //     </td>`;
                        // }
                    }
                    tr += `<tr id="t_${data[col][tHeader[0]]}_${data[col][tHeader[1]]}" onclick="changeColor(this)">${td}</tr>`;
                    td = "";
                }
                $('#dataTable').html(tr);
            } else {
                let columns = JSON.parse(resp.split("|")[1]);
                let data = {};
                let tr = "";
                let th = "";
                for (let h = 0; h < columns.length; h++) {
                    th += `<th>${columns[h]['COLUMN_NAME']}</th>`;
                    data[columns[h]['COLUMN_NAME']] = "";
                }
                tr = `<tr contenteditable="false">${th}</tr>`;
                $('#dataTable').html(tr);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const changeColor = (node) => {
    let array = []
    if (sessionStorage.getItem("cambioColor") !== "true") {
        document.getElementById("new").disabled = true;
        sessionStorage.setItem("idRecord", node.id.split("_")[1]);
        // document.getElementById(node.id).style.background = "blue";
        node.style.background = "blue";
        array = document.getElementsByClassName(`inpu${node.id}`);
        for (let index = 0; index < array.length; index++) {
            array[index].style.color = "white";
            let column = array[index].id.split("_")[0];
            let value = array[index].id.split("_")[1];
            if (column == "Tipo") continue;
            if (column === "EdoCta") {
                if (value === "1") {
                    document.getElementById(column).checked = true;
                } else {
                    document.getElementById(column).cheked = false;
                }
            } else if (column === "Nombre") {
                document.getElementById("Nombres").value = node.id.split("_")[2];
            }
            else {
                document.getElementById(column).value = value;
            }
        }
        document.getElementById("delete").disabled = false;
        document.getElementById("update").disabled = false;
        document.getElementById("cancel").disabled = false;
        sessionStorage.setItem("cambioColor", "true")
    }
}

const cancelar = () => {
    inputs.map((id) => {
        let element = document.getElementById(id);
        element.disabled = true;

        if (id === "FechaIni") element.value = "2021-01-01";
        else if (id === "FechaFin") element.value = "2021-01-10";
        else if (id === "EdoCta") element.checked = false;
        else element.value = "";
    });
    sessionStorage.setItem("cambioColor", "false");
    document.getElementById("new").disabled = false;
    document.getElementById("delete").disabled = true;
    document.getElementById("update").disabled = true;
    document.getElementById("cancel").disabled = true;
    document.getElementById("new").value = "Nuevo";
    document.getElementById("update").value = "Modificar";
    getDataTables();
}


const deleteRegister = () => {
    deleteNode = parseInt(sessionStorage.getItem("idRecord"));
    let cvuser = parseInt(sessionStorage.getItem("cvUser"));
    if (deleteNode === cvuser) {
        alert("No puedes eliminar este registro, porque esta en uso")
    } else {
        $('#modalEliminar').modal('show');
        $('#txtModal').text(`¿Deseas eliminar, el registro con Clave igual a ${deleteNode}?`);
    }

}

const deleteRegisterModal = () => {
    const column = "CvUser";
    const id = deleteNode;
    const table = "musuarios";
    const postType = "Delete";

    $('#modalEliminar').modal('hide');
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            column,
            id,
            table,
            postType
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            getDataTables();
            cancelar();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const nuevoLogin = (node) => {
    let value = node.value;
    if (value === "Nuevo") {
        node.value = "Guardar";
        document.getElementById("cancel").disabled = false;
        inputs.map((id) => {
            document.getElementById(id).disabled = false;
        })
    } else {
        // node.value = "Nuevo";
        insertUser();
        document.getElementById("cancel").disabled = false;
        // inputs.map((id) => {
        //     let element = document.getElementById(id);
        //     element.disabled = true;

        //     if (id === "FechaIni") element.value = "2021-01-01";
        //     else if (id === "FechaFin") element.value = "2021-01-10";
        //     else element.value = "";
        // });
    }
}

const insertUser = () => {
    const table = "musuarios";
    const postType = "Insert";
    let nombre = document.getElementById("Nombres").value
    let login = document.getElementById("Login").value
    let password = document.getElementById("Password").value
    let fechaIni = document.getElementById("FechaIni").value
    let fechaFin = document.getElementById("FechaFin").value
    let status = document.getElementById("EdoCta").checked;

    let sqlInsert = `INSERT INTO ${table} (IdCatRelInfo,Login,Password,FechaIni,FechaFin,EdoCta) VALUES 
    (${nombre}, '${login}','${password}','${fechaIni}','${fechaFin}', ${status})`;
    let sqlSelect = `SELECT * FROM ${table} WHERE Login ='${login}' OR Password = '${password}'`;
    console.log(sqlInsert)
    console.log(sqlSelect)

    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType,
            sqlInsert,
            sqlSelect
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            console.log("resp insert", resp);
            if (resp === "Registro insertado correctamente") {
                alert(resp);
                getDataTables();
                cancelar();
            } else if (resp === "Login y/o contraseña existentes") {
                alert("Registro existente!")
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const updateAvailability = (node) => {
    let value = node.value;
    if (value === "Modificar") {
        node.value = "Guardar";
        document.getElementById("cancel").disabled = false;
        document.getElementById("delete").disabled = true;
        inputs.map((id) => {
            document.getElementById(id).disabled = false;
        })
    } else {
        // node.value = "Modificar";
        updateUser();
        document.getElementById("cancel").disabled = false;
        // inputs.map((id) => {
        //     let element = document.getElementById(id);
        //     element.disabled = true;

        //     if (id === "FechaIni") element.value = "2021-01-01";
        //     else if (id === "FechaFin") element.value = "2021-01-10";
        //     else element.value = "";
        // });
    }
}

const updateUser = () => {

    const table = "musuarios";
    const postType = "Update";
    // let nombre = document.getElementById("Nombre").value
    let login = document.getElementById("Login").value
    let password = document.getElementById("Password").value
    let fechaIni = document.getElementById("FechaIni").value
    let fechaFin = document.getElementById("FechaFin").value
    let status = document.getElementById("EdoCta").checked;
    const id = parseInt(sessionStorage.getItem("idRecord"));
    //Nombre = '${nombre}',
    let sqlUpdate = `UPDATE ${table} 
    SET Login = '${login}', Password = '${password}',
     FechaIni = '${fechaIni}', FechaFin = '${fechaFin}', EdoCta = ${status} WHERE CvUser = ${id}`;

    let sqlSelect = `SELECT * FROM ${table} WHERE CvUser <> ${id} AND (Login ='${login}' OR Password = '${password}')`;//OR Nombre = '${nombre}'
    console.log(sqlSelect)
    console.log(sqlUpdate)
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType,
            sqlUpdate,
            sqlSelect
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            console.log(resp);debugger
            if (resp === "Records were updated successfully") {
                alert("Registro actualizado correctamente!")
                getDataTables();
                cancelar();
            } else if (JSON.parse(resp).length > 0) {
                alert("Registro existente!")
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });

}

const getCurrentDate = () => {
    const dateOb = new Date();

    const date = `0${dateOb.getDate()}`.slice(-2);
    const month = `0${dateOb.getMonth() + 1}`.slice(-2);
    const year = dateOb.getFullYear();
    return `${year}-${month}-${date}`;
};

const getDateFormat = (fecha) => {
    const day = fecha.getDate();
    // el mes es devuelto entre 0 y 11
    const d = day < 10 ? `0${day}` : day;
    const month = (fecha.getMonth() + 1) < 10 ? "0" + (fecha.getMonth() + 1) : (fecha.getMonth() + 1);
    const year = fecha.getFullYear();
    return `${year}-${month}-${d}`;
};

const addDaysToDate = (days, f) => {
    const fecha = new Date(f);
    fecha.setDate(fecha.getDate() + days);
    return getDateFormat(fecha);
};