<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/userMaintenance.css">
    <title>Mantenimiento de usuarios</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light" style="background-color: #E3F2FD;">
        <h5 class="navbar-brand">Mantenimiento de usuarios</h5>
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
            <div class="col-md-4">
                <div class="section-card">
                    <form>
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre de usuario</label>
                            <!-- <input type="text" disabled class="form-control" id="Nombre"> -->
                            <select class="form-control" id="Nombres" disabled aria-label="Default select example">
                                <option value="" selected>-Selecciona una opción-</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="Login" class="form-label">Login del usuario</label>
                            <input type="text" disabled class="form-control" id="Login">
                        </div>
                        <div class="mb-3">
                            <label for="Password" class="form-label">Contraseña</label>
                            <!-- <input type="password" disabled class="form-control" id="Password"> -->
                            <div class="input-group">
                                <input type="password" disabled name="Password" id="Password" class="form-control" data-toggle="password">
                                <div class="input-group-append" id="show_hide_password">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="FechaIni" class="form-label">Fecha de inicio</label>
                            <input class="form-control" type="date" disabled value="2021-01-01" id="FechaIni">
                        </div>
                        <div class="mb-3">
                            <label for="FechaFin" class="form-label">Fecha de termino</label>
                            <input class="form-control" type="date" disabled value="2021-01-10" id="FechaFin">
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="" id="EdoCta">
                            <label class="form-check-label" for="flexCheckDefault">
                                Estado de la cuenta
                            </label>
                        </div>
                        <!-- <input type="button" class="btn btn-primary" value="Continuar" /> -->
                    </form>
                </div>
            </div>
            <div class="col-md-8">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../js/userMaintenance.js"></script>
    <script src="../js/bootstrap-show-password.js"></script>
    <script>
        $(document).ready(() => {
            const login = sessionStorage.getItem("login");
            document.getElementById("user").innerText = 'Cuenta en sesión: ' + sessionStorage.getItem("user").toUpperCase();
            if (login !== "true") {
                window.location.href = "../";
            }
        })
    </script>
    </script>
</body>

</html>