<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/home.css">
    <title>Inicio</title>
</head>

<body>
    <ul class="nav justify-content-end">
        <li class="nav-item">
            <div class="nav-link" id="user"></div>
        </li>
        <li class="nav-item" onclick="logout()">
            <div class="nav-link">Cerrar sesíon</div>
        </li>
    </ul>
    <div class="container">
        <div id="content-img">
            <img src="../images/icon.svg" alt="" srcset="">
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card" onclick="redirect('catalog-maintenance')">Mantenimiento de catalogos</div>
            </div>
            <div class="col-md-4">
                <div class="card" onclick="redirect('user-maintenance')">Mantenimiento de usuarios</div>
            </div>
            <div class="col-md-4">
                <div class="card" onclick="redirect('personal-information')">Datos personales</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card" onclick="redirect('change-password')">Cambiar contraseña</div>
            </div>
            <div class="col-md-4">
                <div></div>
            </div>
            <div class="col-md-4">
                <div></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../js/home.js"></script>
    <script>
        $(document).ready(() => {
            const login = sessionStorage.getItem("login")
            document.getElementById("user").innerText = sessionStorage.getItem("user");
            if (login !== "true") {
                window.location.href = "../";
            }
        })
    </script>
</body>

</html>