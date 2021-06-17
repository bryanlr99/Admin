let deleteNode;
$(document).ready(() => {
    getDataTables();
    sessionStorage.setItem("cambioColor", "false");
    fillSelectsDatPerson("nombre");
    fillSelectsDatPerson("apellidos");
    fillSelectsDatPerson("municipio");
    fillSelectsDatPerson("genero");
    fillSelectsDatPerson("estado");
    fillSelectsDatPerson("colonia");
    fillSelectsDatPerson("calle");
    fillSelectsDatPerson("cattipoperson");

});

const fillSelectsDatPerson = (table, col) => {
    $.ajax({
        type: "POST", // tipo de request que estamos generando
        url: "../server.php", // URL a la que estamos haciendo el request
        data: {
            postType: "fillSelDatPerson",
            table,
        },// data es un JSON que contiene los parámetros que se enviaran al servidor indicado en la url  
        async: true,// si es asincrónico o no
        success: function (resp) {
            let arrayTables = JSON.parse(resp);
            // console.log(arrayTables)
            let keys = Object.keys(arrayTables[0]);
            let option = "";
            if (table === "apellidos") {
                for (const item of arrayTables) {
                    option += `<option value='${item[keys[0]]}' >${item[keys[1]]} ${item[keys[2]]}</option>`
                }
                $(`#${table}`).append(option)
            } else {
                for (const item of arrayTables) {
                    option += `<option value='${item[keys[0]]}' >${item[keys[1]]}</option>`
                }
                $(`#${table}`).append(option)
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const inputs = ['nombre', 'apellidos', 'edad', 'genero', 'email', 'telefono', 'curp', 'rfc', 'fechaNac', 'calle', 'colonia', 'cp', 'municipio', 'estado', 'numExt', 'cattipoperson'];
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
        inputs.map((id) => {
            let element = document.getElementById(id);
            element.disabled = true;
            element.value = "";
        });
    }
}

const insertUser = () => {
    const table = "catreluserinformation";
    const postType = "Insert";
    let curp = document.getElementById("curp").value;
    let rfc = document.getElementById("rfc").value;
    let values = inputs.map((id) => {
        let element = document.getElementById(id);
        if (id === "nombre" || id === "apellidos" || id === "edad" || id === "genero" || id === "telefono"
            || id === "calle" || id === "colonia" || id === "cp" || id === "municipio" || id === "estado"
            || id === "numExt" || id === "cattipoperson") return parseInt(element.value) || 0;
        else return `'${element.value}'` || "";
    })

    let sqlInsert = `INSERT INTO ${table} (CvNombre,CvApellidos,Edad,CvGenero,Email,Telefono,Curp,Rfc,FechaNacimiento,CvCalle,CvColonia,CodigoPostal,CvMunicipio,CvEstado,NumExt,CvTipoPersona) VALUES 
    (${values.join(",")})`;
    let sqlSelect = `SELECT * FROM ${table} WHERE Curp ='${curp}' Or Rfc = '${rfc}'`;
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
                alert("Registro con Curp existente!" + curp)
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}

const getDataTables = () => {

    const postType = "personal-getDataTable";

    let data = {
        postType
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
                sessionStorage.setItem("infoComplete", resp.split("|")[1]);
                sessionStorage.setItem("jsonTable", resp.split("|")[2]);
                let dataKeys = JSON.parse(resp.split("|")[2]);

                let tHeader = Object.keys(data[0]);

                let tr = "";
                let th = "";
                let td = "";
                for (let h = 0; h < tHeader.length; h++) {
                    if (h !== 0) {
                        th += `<th>${tHeader[h]}</th>`;
                    }
                }
                // th += `<th>Acción</th>`;
                tr = `<tr contenteditable="false">${th}</tr>`
                for (let col = 0; col < data.length; col++) {
                    let valuesByObj = Object.values(dataKeys[col]);
                    for (let key = 0; key < tHeader.length; key++) {
                        if (key === 0) {
                            td += `
                            <td contenteditable="false" style="display:none">
                                <input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                        } else {
                            td += `
                            <td contenteditable="false">
                                <input disabled id="${tHeader[key]}_${valuesByObj[key]}" class="input_${data[col][tHeader[0]]}_${data[col][tHeader[1]]} hideStyle" type="text" value="${data[col][tHeader[key]]}">
                            </td>`;
                            // `<input disabled id="${tHeader[key]}_${data[col][tHeader[key]]}" class="input_${data[col][tHeader[0]]}_${data[col][tHeader[1]]} hideStyle" type="text" value="${data[col][tHeader[key]]}"></input>`
                        }
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
        sessionStorage.setItem("idRecord", node.id.split("_")[1]);//idcatrel
        // document.getElementById(node.id).style.background = "blue";
        node.style.background = "blue";
        array = document.getElementsByClassName(`inpu${node.id}`);
        for (let index = 0; index < array.length; index++) {
            array[index].style.color = "white";
            let column = inputs[index];
            let value = array[index].id.split("_")[1];
            document.getElementById(column).value = value;
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

        if (id === "fechaNac") element.value = "2021-01-01";
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

    const table = "catreluserinformation";
    const postType = "Update";

    let curp = document.getElementById("curp").value;
    let rfc = document.getElementById("rfc").value;
    let values = inputs.map((id) => {
        let element = document.getElementById(id);
        if (id === "nombre" || id === "apellidos" || id === "edad" || id === "genero" || id === "telefono"
            || id === "calle" || id === "colonia" || id === "cp" || id === "municipio" || id === "estado"
            || id === "numExt" || id === "cattipoperson") return parseInt(element.value) || 0;
        else return `'${element.value}'` || "";
    })
    const id = parseInt(sessionStorage.getItem("idRecord"));


    let sqlUpdate = `UPDATE ${table} 
    SET CvNombre = ${values[0]}, CvApellidos = ${values[1]},Edad = ${values[2]}, CvGenero = ${values[3]},Email = ${values[4]},
    Telefono = ${values[5]}, Curp = ${values[6]}, Rfc = ${values[7]}, FechaNacimiento = ${values[8]}, CvCalle = ${values[9]},
    CvColonia = ${values[10]},CodigoPostal = ${values[11]},CvMunicipio = ${values[12]},CvEstado = ${values[13]},NumExt = ${values[14]},CvTipoPersona = ${values[15]}
    WHERE IdCatRel = ${id}`;

    let sqlSelect = `SELECT * FROM ${table} WHERE IdCatRel <> ${id} AND (Curp ='${curp}' OR Rfc = '${rfc}')`;//OR Nombre = '${nombre}'
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
            console.log(resp);
            if (resp === "Records were updated successfully") {
                alert("Registro actualizado correctamente!")
                getDataTables();
                cancelar();
            } else if (JSON.parse(resp).length > 0) {
                alert(`ya existe un registro con la CURP: ${curp}`)
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });

}


const deleteRegister = () => {
    deleteNode = parseInt(sessionStorage.getItem("idRecord"));
    let idCatRel = parseInt(sessionStorage.getItem("idCatRel"));
    if (deleteNode === idCatRel) {
        alert("No puedes eliminar este registro, porque esta en uso")
    } else {
        $('#modalEliminar').modal('show');
        $('#txtModal').text(`¿Deseas eliminar, el registro con Clave igual a ${deleteNode}?`);
    }

}

const deleteRegisterModal = () => {
    const column = "IdCatRel";
    const id = deleteNode;
    const table = "catreluserinformation";
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
            console.log(resp)
            if (resp === "Records were deleted successfully.") {
                alert("Registro eliminado!");
                getDataTables();
                cancelar();
            } else {
                alert("Hubo un error al eliminar, intentelo de nuevo");
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown) { // función que va a ejecutar si hubo algún tipo de error en el pedido
            console.log(errorThrown);
        }
    });
}