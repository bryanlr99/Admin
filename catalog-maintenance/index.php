<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/catMaintenance.css">
    <title>Mantenimiento de datos personales</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div id="container-form">
                    <div id="content-select">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect01">Catalogos</label>
                            </div>
                            <select class="custom-select" id="catalogos" onchange="getDataTables()">
                                <option selected>-Selecciona una tabla-</option>
                            </select>
                        </div>
                    </div>
                    <div id="content-mantto">
                        <div id="content-description">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">Descripción</span>
                                </div>
                                <input type="text" disabled class="form-control" id="description" aria-describedby="basic-addon3">
                            </div>
                        </div>
                        <div class="table_btns">
                            <table id="dataTable">
                                <tr contenteditable="false">
                                    <!-- <th>CvUser</th>
                                    <th>Nombres</th>
                                    <th>Nombres</th> -->
                                </tr>
                            </table>
                            <div class="container-buttons">
                                <input class="actions-btn" disabled type="button" name="new" id="new" value="Nuevo" onclick="newRecord(this)">
                                <input class="actions-btn" disabled type="button" name="delete" id="delete" value="Eliminar" onclick="deleteRegister()">
                                <input class="actions-btn" disabled type="button" name="update" id="update" value="Modificar" onclick="updateAvailability(this)">
                                <input class="actions-btn" disabled type="button" name="cancel" id="cancel" value="Cancelar" onclick="cancelar()">
                                <input class="actions-btn" type="button" name="exit" id="exit" value="Salir" onclick="window.location.href = '../home'">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onClick="deleteRegisterModal()">Sí, eliminar</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script src="../js/catMaintenance.js"></script>
</body>

</html>