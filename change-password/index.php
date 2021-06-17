<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">
    <title>Mantenimiento de datos personales</title>
</head>

<body>
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
                            <input type="password" class="form-control" id="lastPassword">
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword">
                        </div>
                        <div class="mb-3">
                            <label for="confirmNewPassword" class="form-label">Confirmar nueva contraseña</label>
                            <input type="password" class="form-control" id="confirmNewPassword">
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
    <script>
        $(document).ready(() => {
            const login = sessionStorage.getItem("login")
            if (login !== "true") {
                window.location.href = "../";
            }
        })
    </script>
</body>

</html>