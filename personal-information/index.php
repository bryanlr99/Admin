<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/personalInformation.css">
    <title>Datos personales</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light" style="background-color: #E3F2FD;">
        <h5 class="navbar-brand">Mantenimiento de datos personales</h5>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <div class="nav-link" style="text-decoration: none;" id="user"></div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="section-card">
                    <h4>Datos personales</h4>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="cattipoperson" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="cattipoperson">Tipo de persona</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="curp" maxlength="18" placeholder=" " value="">
                                <label for="curp">CURP</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="rfc" maxlength="13" placeholder=" " value="">
                                <label for="rfc">RFC</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="nombre" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="nombre">Nombre</label>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="apellidos" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="apellidos">Apellidos</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="edad" maxlength="3" placeholder=" " value="">
                                <label for="edad">Edad</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="genero" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                    <!-- <option value="Masculino">Masculino</option>
                                    <option value=" Femenino">Femenino</option> -->
                                </select>
                                <label for="genero">Genero</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input class="form-control" disabled type="date" value="2021-01-10" id="fechaNac">
                                <label for="fechaNac">Fecha de nacimiento</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="email" placeholder=" " value="">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="telefono" maxlength="10" placeholder=" " value="">
                                <label for="telefono">Telefono</label>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
            <!-- ******************************************************************************************************************************** -->
            <div class="col-md-6">
                <div class="section-card">
                    <h4>Dirección</h4>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="calle" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="calle">Calle</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="colonia" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="colonia">Colonia</label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="municipio" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="municipio">Municipio</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <select class="form-select" disabled id="estado" aria-label="Floating label select example">
                                    <option selected>Selecciona una opción</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="numExt" placeholder=" " value="">
                                <label for="numExt">Número externo</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" class="form-control" disabled id="cp" maxlength="5" placeholder=" " value="">
                                <label for="cp">Código postal</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="section-card section-actions">
                    <div id="content-img">
                        <img src="../images/icon.svg" alt="" srcset="">
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="actions-btn" type="button" name="new" id="new" value="Nuevo" onclick="nuevoLogin(this)">
                        </div>
                        <div class="col">
                            <input class="actions-btn" disabled type="button" name="delete" id="delete" value="Eliminar" onclick="deleteRegister()">
                        </div>
                        <div class="col">
                            <input class="actions-btn" disabled type="button" name="update" id="update" value="Modificar" onclick="updateAvailability(this)">
                        </div>
                        <div class="col">
                            <input class="actions-btn" disabled type="button" name="cancel" id="cancel" value="Cancelar" onclick="cancelar()">
                        </div>
                        <div class="col">
                            <input class="actions-btn" type="button" name="exit" id="exit" value="Salir" onclick="window.location.href = '../home'">
                        </div>
                    </div>

                    <table id="dataTable" contenteditable="TRUE">
                    </table>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="txtModal" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onClick="deleteRegisterModal()">Sí, eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="../js/personalInformation.js"></script>
    <script>
        $(document).ready(() => {
            const login = sessionStorage.getItem("login");
            document.getElementById("user").innerText = 'Cuenta en sesión: ' + sessionStorage.getItem("user").toUpperCase();
            if (login !== "true") {
                window.location.href = "../";
            }
        })
    </script>
</body>

</html>