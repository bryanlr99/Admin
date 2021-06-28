<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">
    <title>Cambiar contraseña</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-light" style="background-color: #E3F2FD;">
        <h5 class="navbar-brand">Cambiar contraseña</h5>
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
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="container-form">
                    <div id="content-img">
                        <img src="../images/icon.svg" alt="" srcset="">
                    </div>
                    <h1 style="font-size: 25px;">Cambiar Contraseña</h1>
                    <form>
                        <div class="mb-3">
                            <label for="lastPassword" class="form-label">Contraseña anterior</label>
                            <!-- <input type="password" class="form-control" id="lastPassword"> -->
                            <div class="input-group">
                                <input type="password" name="lastPassword" id="lastPassword" class="form-control" data-toggle="password">
                                <div class="input-group-append" id="show_hide_password">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva contraseña</label>
                            <!-- <input type="password" class="form-control" id="newPassword"> -->
                            <div class="input-group">
                                <input type="password" name="newPassword" id="newPassword" class="form-control" data-toggle="password">
                                <div class="input-group-append" id="show_hide_password">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirmar nueva contraseña</label>
                            <!-- <input type="password" class="form-control" id="confirmNewPassword"> -->
                            <div class="input-group">
                                <input type="password" name="confirmNewPassword" id="confirmNewPassword" class="form-control" data-toggle="password">
                                <div class="input-group-append" id="show_hide_password">
                                    <span class="input-group-text">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <p id="message"></p>
                        <input type="button" class="btn btn-primary" value="Continuar" onclick="changePassword()" />
                    </form>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../js/changePassword.js"></script>
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
</body>

</html>