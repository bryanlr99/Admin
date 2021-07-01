let deleteNode;
$(document).ready(() => {
    fillSelect();
    sessionStorage.setItem("cambioColor", "false");
})

const fillSelect = () => {
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType: "fillSelectCat",
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            // console.log(resp)
            let arrayTables = JSON.parse(resp);
            let option = "";
            for (const item of arrayTables) {
                if (item.nombre !== "catreluserinformation" && item.nombre !== "musuarios" && item.nombre !== "cattipoperson") {
                    option += `<option value='${item.nombre}' >${item.nombre} </option>`
                }
            }
            $("#catalogos").append(option)
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const getDataTables = () => {
    const table = document.getElementById('catalogos').value;
    document.getElementById("new").disabled = false;
    let description = document.getElementById("description");
    description.value = '';
    description.disabled = true;
    // console.log(table);
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            table,
            postType: 'getDataTables'
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            let response = resp.split("|");
            if (response[0] === "data") {
                let data = JSON.parse(response[1]);
                // sessionStorage.setItem("data", JSON.stringify(data));
                let tHeader = Object.keys(data[0]);
                // sessionStorage.setItem('theader', JSON.stringify(tHeader));
                // console.log(data);
                // console.log(tHeader);
                let tr = "";
                let th = "";
                let td = "";
                for (let h = 0; h < tHeader.length; h++) {
                    th += `<th>${tHeader[h]}</th>`;
                    if (table === 'apellidos') {
                        sessionStorage.setItem("columnsInsert", `${tHeader[1]},${tHeader[2]}`)
                    } else {
                        sessionStorage.setItem("columnsInsert", tHeader[1])
                    }
                }
                // th += `<th>Acción</th>`;
                tr = `<tr contenteditable="false">${th}</tr>`
                for (let col = 0; col < data.length; col++) {
                    for (let key = 0; key < tHeader.length; key++) {
                        console.log("columnas", tHeader[key], " <-> ", data[col][tHeader[key]])
                        if (key === 0) {
                            td += `
                            <td contenteditable="false">
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;

                        } else {
                            td += `
                            <td>
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="input_${data[col][tHeader[0]]} hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                            // td += `<td><input id="${tHeader[key]}_${data[col][tHeader[key]]}" class="campo_${data[col][tHeader[0]]} hideStyle" type="text" onClick="updateRegister(this)" value="${data[col][tHeader[key]]}"></td>`;

                        }
                    }
                    tr += `<tr id="row_${tHeader[0]}_${data[col][tHeader[0]]}" onclick="selectedRow(this)">${td}</tr>`;
                    td = "";
                }
                $('#dataTable').html(tr);

            } else {
                $('#dataTable').html(`<tr contenteditable="false"><td>Sin datos</td</tr>`);

            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const selectedRow = (node) => {
    let array = []
    if (sessionStorage.getItem("cambioColor") !== "true") {
        document.getElementById("new").disabled = true;
        sessionStorage.setItem("idRecord", node.id.split("_")[2]);
        sessionStorage.setItem("colRecord", node.id.split("_")[1]);
        node.style.background = "blue";

        array = document.getElementsByClassName(`input_${node.id.split("_")[2]}`);
        let auxVal = "";
        let column = "";
        for (let index = 0; index < array.length; index++) {
            let description = document.getElementById("description");
            array[index].style.color = "white";
            column += array[index].id.split("_")[0] + ",";

            let value = array[index].id.split("_")[1];
            auxVal += value + " ";
            description.value = auxVal.trim();
        }
        sessionStorage.setItem("columnsInsert", column.slice(0, -1))
        document.getElementById("delete").disabled = false;
        document.getElementById("update").disabled = false;
        document.getElementById("cancel").disabled = false;
        sessionStorage.setItem("cambioColor", "true")
    }
}


const cancelar = () => {
    let description = document.getElementById("description");
    description.value = "";
    description.disabled = true;
    sessionStorage.setItem("cambioColor", "false");
    document.getElementById("new").disabled = false;
    document.getElementById("delete").disabled = true;
    document.getElementById("update").disabled = true;
    document.getElementById("cancel").disabled = true;
    document.getElementById("new").value = "Nuevo";
    document.getElementById("update").value = "Modificar";
    getDataTables();
}

const updateAvailability = (node) => {
    let value = node.value;
    let description = document.getElementById("description");
    if (value === "Modificar") {
        node.value = "Guardar";
        document.getElementById("cancel").disabled = false;
        document.getElementById("delete").disabled = true;
        description.disabled = false;
    } else {        
        if (description.value === '' || description.value === ' ') {
            alert('El campo Descripción no debe estar vacío');
        } else {
            // node.value = "Modificar";
            updateUser();
            document.getElementById("cancel").disabled = false;
        }

    }
}

const updateUser = () => {

    const postType = "Update";

    const table = document.getElementById('catalogos').value;
    let description = document.getElementById("description").value;

    const id = parseInt(sessionStorage.getItem("idRecord"));
    const column = sessionStorage.getItem("colRecord");

    //Nombre = '${nombre}',
    let sqlUpdate = "";
    let sqlSelect = "";
    if (column === "CvApellido") {
        let columns = sessionStorage.getItem("columnsInsert").split(",");
        description = description.split(" ");        
        let cols = sessionStorage.getItem("columnsInsert").split(",");
        sqlSelect = `SELECT * FROM ${table} WHERE ${cols[0]} = BINARY '${description[0]}' AND ${cols[1]} = BINARY '${description[1]}'`        

        sqlUpdate = `UPDATE ${table} 
        SET ${columns[0]} = '${description[0]}', ${columns[1]} = '${description[1]}' WHERE ${column} = ${id}`;
    } else {
        let columns = sessionStorage.getItem("columnsInsert");
        sqlSelect = `SELECT * FROM ${table} WHERE ${sessionStorage.getItem("columnsInsert")} = BINARY '${description}'`
        sqlUpdate = `UPDATE ${table} SET ${columns} = '${description}' WHERE ${column} = ${id}`;
    }

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
            console.log(resp)
            if (resp === "Records were updated successfully") {
                alert("Registro actualizado correctamente!");
                document.getElementById("update").value = 'Modificar';
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

const newRecord = (node) => {
    let value = node.value;
    let description = document.getElementById("description");
    if (value === "Nuevo") {
        node.value = "Guardar";
        document.getElementById("cancel").disabled = false;

        description.disabled = false;

    } else {
        if (description.value === '' || description.value === ' ') {
            alert('El campo Descripción no debe estar vacío');
        } else {
            node.value = "Nuevo";
            insertUser();
            document.getElementById("cancel").disabled = true;
            // description.disabled = true;
            // description.value = "";
        }
    }
}

const insertUser = () => {
    const table = document.getElementById('catalogos').value;
    const postType = "InsertFromCatMaintenance";



    let description = document.getElementById("description").value
    let idRow = sessionStorage.getItem("idRecord");

    let sqlInsert = ""
    let sqlSelect = ""

    if (table === "apellidos") {
        let validColumn = description.split(" ");
        let cols = sessionStorage.getItem("columnsInsert").split(",");
        // sqlInsert = `INSERT INTO ${table} (${sessionStorage.getItem("columnsInsert")}) VALUES 
        // ('${validColumn[0]}', '${validColumn[1]}')`;
        sqlSelect = `SELECT * FROM ${table} WHERE ${cols[0]} = BINARY '${validColumn[0]}' AND ${cols[1]} = BINARY '${validColumn[1]}'`
        sqlInsert = `INSERT INTO ${table} VALUES (NULL,'${validColumn[0]}', '${validColumn[1]}')`;
    } else {
        // sqlInsert = `INSERT INTO ${table} (${sessionStorage.getItem("columnsInsert")}) VALUES 
        // ('${description}')`;
        sqlSelect = `SELECT * FROM ${table} WHERE ${sessionStorage.getItem("columnsInsert")} = BINARY '${description}'`
        sqlInsert = `INSERT INTO ${table} VALUES (NULL,'${description}')`;

    }
    console.log(sqlInsert);
    console.log(sqlSelect);

    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType,
            sqlInsert,
            sqlSelect,
            flag: sessionStorage.getItem("flag")
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            let response = resp.split("_");
            if (response[0] === "Registro insertado correctamente") {
                sessionStorage.setItem("lastIdByTable", response[1]);//ultimo id por tabla
                sessionStorage.setItem("lastIdByTableAux", response[1]);//ultimo id por tabla
                alert("Registro insertado correctamente")
                // insertUpdateCatRel();
                getDataTables();
                cancelar();
            } else if (response[0] === "Existente") {
                alert(`El registro "${description} ya existe"`)
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const insertUpdateCatRel = () => {
    const table = document.getElementById('catalogos').value;
    const postType = "CatRelInfo";
    const inserts = ['null', 0, 0, 'null', 0, 'null', 'null', 'null', 'null', 'null', 0, 0, 'null', 0, 0, 'null', 0];
    const tablas = ['null', 'nombre', 'apellidos', '', 'genero', '', '', '', '', '', 'calle', 'colonia', '', 'municipio', 'estado', '', 'cattipoperson'];
    const columnas = ['null', 'CvNombre', 'CvApellidos', '', 'CvGenero', '', '', '', '', '', 'CvCalle', 'CvColonia', '', 'CvMunicipio', 'CvEstado', '', 'CvTipoPersona']
    let sqlInsert = "";
    let updateCatRel = "";
    let tipo = "";
    if (sessionStorage.getItem("flag") !== "true" || (sessionStorage.getItem("lastIdByTable") > sessionStorage.getItem("lastId"))) {
        for (let index = 0; index < tablas.length; index++) {
            if (table === tablas[index]) {
                inserts[index] = sessionStorage.getItem("lastIdByTable");
                sqlInsert = `INSERT INTO catreluserinformation VALUES (${inserts.join()})`;
                tipo = "insert"
                break;
            }
        }
    } else {
        for (let index = 0; index < tablas.length; index++) {
            if (table === tablas[index]) {
                updateCatRel = `UPDATE catreluserinformation SET ${columnas[index]} = ${sessionStorage.getItem("lastIdByTable")} WHERE IdCatRel = ${sessionStorage.getItem("lastIdByTable")}`;
                tipo = "update"
                break;
            }
        }
    }
    console.log(sqlInsert)
    console.log(updateCatRel)
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType,
            sqlInsert,
            updateCatRel,
            tipo
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            let response = resp.split("_");
            if (response[0] === "Registro insertado correctamente") {
                sessionStorage.setItem("flag", "true");
                sessionStorage.setItem("lastId", response[1]);
            } else {
                sessionStorage.setItem("lastId", sessionStorage.getItem("lastId"));
            }
            // getDataTables();
            // cancelar();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const deleteRegister = (node) => {
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
    const column = sessionStorage.getItem("colRecord");
    const id = deleteNode;
    const table = document.getElementById('catalogos').value;
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
            console.log("eliminado", resp)
            if (resp.includes('ERROR')) {
                alert('El registro no puede ser eliminado ya que son datos de otro usuario')
            }
            getDataTables();
            cancelar();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}