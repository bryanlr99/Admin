<?php
include('./mysqlConnection.php');
$postType = $_POST["postType"];
date_default_timezone_set("America/Mexico_City");
switch ($postType) {
    case 'fillSelDatPerson':
        $table = $_POST["table"];
        $sqlQuery = "SELECT * FROM $table";
        $result = $conexion->query($sqlQuery);
        $array = [];
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $array[] = $data;
            }
            echo json_encode($array);
        } else {
            echo "Sin registros en la tabla";
        }
        break;
    case 'fillSelectCat':
        $bd = $DatabaseName;

        $sql = "SELECT table_name AS nombre
        FROM information_schema.tables WHERE table_schema = '{$bd}';";
        $result = mysqli_query($conexion, $sql);
        if (!$result) {
            echo "Error de BD";
            exit;
        }
        while ($data = mysqli_fetch_assoc($result)) {
            $array[] = $data;
        }
        echo json_encode($array);

        break;
    case 'fillSelect':
        $table = $_POST["table"];

        $sqlQuery = "SELECT
        CRUI.IdCatRel,
        nombre.Nombres,
        apellidos.ApellidoPat,
        apellidos.ApellidoMat
        FROM
        {$table} AS CRUI
        INNER JOIN nombre ON CRUI.CvNombre = nombre.CvNombre
        INNER JOIN apellidos ON CRUI.CvApellidos = apellidos.CvApellido;";

        $result = mysqli_query($conexion, $sqlQuery);
        $array = [];
        while ($data = mysqli_fetch_assoc($result)) {
            $array[] = $data;
        }
        echo json_encode($array);
        break;
    case 'queryGetTables':
        $table = $_POST["table"];
        // $sqlQuery = "SELECT * FROM {$table}";
        $sqlQuery = "SELECT CvUser, IdCatRel, Tipo, CONCAT(Nombres,' ',ApellidoPat, ' ', ApellidoMat) AS Nombre,
        Login, `Password`, FechaIni, FechaFin, EdoCta FROM musuarios
        INNER JOIN catreluserinformation AS CRUI ON  CRUI.IdCatRel = musuarios.IdCatRelInfo
        INNER JOIN nombre ON  nombre.CvNombre = CRUI.CvNombre
        INNER JOIN apellidos ON  apellidos.CvApellido = CRUI.CvApellidos
        INNER JOIN cattipoperson ON cattipoperson.CvTipoPersona = CRUI.CvTipoPersona;";

        $result = $conexion->query($sqlQuery);
        $array = [];
        // $ultimoId = mysqli_insert_id($conexion);            
        // if ($r = mysqli_fetch_array($result)) 
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $array[] = $data;
            }
            echo "data|" . json_encode($array);
        } else {
            // echo "Sin registros en la tabla";
            $sqlQuery = "SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA  LIKE 'controlaccess'
                AND TABLE_NAME = '{$table}'";
            $result = mysqli_query($conexion, $sqlQuery);

            while ($data = mysqli_fetch_assoc($result)) {
                $array[] = $data;
            }
            echo "solo columnas|" . json_encode($array);
        }
        break;
    case 'ValidLogin':                
        $table = $_POST["table"];
        $login = $_POST["login"];
        $password = $_POST["password"];
        $sqlSelect = $_POST["sqlSelect"];
        $array = [];
        $result = $conexion->query($sqlSelect);
        $date = date("Y") . "-" . date("m") . "-" . date("d");
        $cvUser = "";
        $idCatRel = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $status = $row["EdoCta"];
                $cvUser = $row["CvUser"];
                $idCatRel = $row["IdCatRelInfo"];
            }
            if ($status === "1") {
                $sqlValidDateIni = "SELECT * FROM $table WHERE Login = '{$login}' AND `Password` = '{$password}' AND
                (STR_TO_DATE('{$date}','%Y-%m-%d') >= STR_TO_DATE(`FechaIni`, '%Y-%m-%d'));";

                $validFechaIni = $conexion->query($sqlValidDateIni);

                if ($validFechaIni->num_rows > 0) {

                    $sqlValidDateFin = "SELECT * FROM $table WHERE Login = '{$login}' AND `Password` = '{$password}' AND
                    (STR_TO_DATE('{$date}','%Y-%m-%d') > STR_TO_DATE(`FechaFin`, '%Y-%m-%d'));";

                    $resultVal2 = $conexion->query($sqlValidDateFin);
                    if ($resultVal2->num_rows > 0) {
                        //actualizar estado
                        $sqlUpdate = "UPDATE musuarios SET EdoCta = 0 WHERE Login = '{$login}' AND `Password` = '{$password}';";
                        if (mysqli_query($conexion, $sqlUpdate)) {
                            echo "Estado de cuenta: inactivo";
                        } else {
                            echo "ERROR: Could not able to execute $sqlUpdate. " . mysqli_error($conexion);
                        }
                        mysqli_close($conexion);
                    } else {
                        mysqli_close($conexion);
                        echo "Fecha en rango,$cvUser,$idCatRel,$date";
                    }
                } else {
                    mysqli_close($conexion);
                    echo "Por el momento no puedes acceder al sistema, regresa despues"; //"Fecha actual menor que la inicial";
                }
            } else {
                echo "Cuenta desactivada";
            }
        } else {
            echo "password y/o login incorrectos";
        }
        break;
    case 'Update':
        $sqlUpdate = $_POST["sqlUpdate"];
        $sqlSelect = $_POST["sqlSelect"];
        $result = [];
        if ($sqlSelect != "") {
            // output data of each row
            $result = $conexion->query($sqlSelect);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $array[] = $row;
                }
                echo json_encode($array);
            } else {
                if (mysqli_query($conexion, $sqlUpdate)) {
                    echo "Records were updated successfully";
                } else {
                    echo "ERROR: Could not able to execute $sqlUpdate. " . mysqli_error($conexion);
                }
                mysqli_close($conexion);
            }
        } else {
            if (mysqli_query($conexion, $sqlUpdate)) {
                echo "Records were updated successfully";
            } else {
                echo "ERROR: Could not able to execute $sqlUpdate. " . mysqli_error($conexion);
            }
            mysqli_close($conexion);
        }
        break;
    case 'Delete':
        $column = $_POST["column"];
        $id = $_POST["id"];
        $table = $_POST["table"];

        $sql = "DELETE FROM {$table} WHERE {$column}= {$id}";
        if (mysqli_query($conexion, $sql)) {
            echo "Records were deleted successfully.";
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($conexion);
        }
        mysqli_close($conexion);
        break;
    case 'Insert':
        $sqlSelect = $_POST["sqlSelect"];
        $sqlInsert = $_POST["sqlInsert"];
        $result = $conexion->query($sqlSelect);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "Login y/o contraseña existentes";
            // while ($row = $result->fetch_assoc()) {
            //     $array[] = $row;
            // }
            // echo json_encode($array);
        } else {
            if ($conexion->query($sqlInsert) === TRUE) {
                echo "Registro insertado correctamente";
            } else {
                echo "Error: " . $sqlInsert . "<br>" . $conexion->error;
            }
        }

        break;
    case "ChangePassword":
        $sqlSelect = $_POST["sqlSelect"];
        $sqlUpdatePass = $_POST["sqlUpdatePass"];
        $newPassword = $_POST["newPassword"];
        $confirmNewPassword = $_POST["confirmNewPassword"];

        $result = $conexion->query($sqlSelect);
        if ($result->num_rows > 0) {
            // output data of each row
            if ($newPassword === $confirmNewPassword) {
                if ($conexion->query($sqlUpdatePass) === TRUE) {
                    echo "Contraseña actualizada";
                } else {
                    echo "Error: " . $sqlUpdatePass . "<br>" . $conexion->error;
                }
            } else {
                echo "Las contraseñas no coinciden";
            }
        } else {
            echo "La contraseña anterior es incorrecta";
        }

        break;
    case 'getDataTables':
        $table = $_POST["table"];
        $sqlQuery = "SELECT * FROM {$table}";
        $result = $conexion->query($sqlQuery);

        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $array[] = $data;
            }
            echo "data|" . json_encode($array);
        } else {
            // echo "Sin registros en la tabla";
            $sqlQuery = "SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA  LIKE 'controlaccess'
                AND TABLE_NAME = '{$table}'";
            $result = $conexion->query($sqlQuery);

            while ($data = $result->fetch_assoc()) {
                $array[] = $data;
            }
            echo "solo columnas|" . json_encode($array);
        }
        break;
    case 'InsertFromCatMaintenance':
        $sqlSelect = $_POST["sqlSelect"];
        $sqlInsert = $_POST["sqlInsert"];
        if ($conexion->query($sqlInsert) === TRUE) {
            $last_id = $conexion->insert_id;
            echo "Registro insertado correctamente_{$last_id}";
        } else {
            echo "Error: " . $sqlInsert . "<br>" . $conexion->error;
        }
        break;
    case 'CatRelInfo':
        $sqlInsert = $_POST["sqlInsert"];
        $updateCatRel = $_POST["updateCatRel"];
        $tipo = $_POST["tipo"];
        if ($tipo === "insert") {
            if ($conexion->query($sqlInsert) === TRUE) {
                $last_id = $conexion->insert_id;
                echo "Registro insertado correctamente_{$last_id}";
            } else {
                echo "Error: " . $sqlInsert . "<br>" . $conexion->error;
            }
        } else {
            if (mysqli_query($conexion, $updateCatRel)) {
                echo "Actualizado_";
            } else {
                echo "ERROR: Could not able to execute $sqlUpdate. " . mysqli_error($conexion);
            }
        }

        mysqli_close($conexion);
        break;
    case 'personal-getDataTable':
        // $table = $_POST["table"];
        // $sqlQuery = "SELECT * FROM {$table}";
        $sqlQuery = "SELECT CRUI.IdCatRel,
        nombre.Nombres,CONCAT(apellidos.ApellidoPat,' ',apellidos.ApellidoMat) AS Apellidos,CRUI.Edad,genero.Genero,CRUI.Email,CRUI.Telefono,
        CRUI.Curp,CRUI.Rfc,CRUI.FechaNacimiento,calle.Calle,colonia.Colonia,CRUI.CodigoPostal,municipio.Municipio,
        estado.Estado,CRUI.NumExt,cattipoperson.Tipo
        FROM
        catreluserinformation AS CRUI
        INNER JOIN nombre ON CRUI.CvNombre = nombre.CvNombre
        INNER JOIN apellidos ON CRUI.CvApellidos = apellidos.CvApellido	
        INNER JOIN genero ON CRUI.CvGenero = genero.CvGenero		
        INNER JOIN calle ON CRUI.CvCalle = calle.CvCalle
        INNER JOIN colonia ON CRUI.CvColonia = colonia.CvColonia	
        INNER JOIN municipio ON CRUI.CvMunicipio = municipio.CvMunicipio
        INNER JOIN estado ON CRUI.CvEstado = estado.CvEstado
        INNER JOIN cattipoperson ON CRUI.CvTipoPersona = cattipoperson.CvTipoPersona";

        $result = $conexion->query($sqlQuery);
        $array = [];
        $array_key = [];
        // $ultimoId = mysqli_insert_id($conexion);            
        // if ($r = mysqli_fetch_array($result)) 
        if ($result->num_rows > 0) {
            while ($data = $result->fetch_assoc()) {
                $array[] = $data;
            }
            $resultkey = $conexion->query("SELECT * FROM catreluserinformation");
            if ($resultkey->num_rows > 0) {
                while ($data_key = $resultkey->fetch_assoc()) {
                    $array_key[] = $data_key;
                }
            }
            echo "data|" . json_encode($array) . "|" . json_encode($array_key);
        } else {
            // echo "Sin registros en la tabla";
            $sqlQuery = "SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA  LIKE 'controlaccess'
                AND TABLE_NAME = '{$table}'";
            $result = mysqli_query($conexion, $sqlQuery);

            while ($data = mysqli_fetch_assoc($result)) {
                $array[] = $data;
            }
            echo "solo columnas|" . json_encode($array);
        }
        break;
    default:
        # code...
        break;
}
