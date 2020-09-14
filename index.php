<?php
require __DIR__ . '/vendor/autoload.php';


use Symfony\Component\Dotenv\Dotenv;
use Models\TOC;

//Iniciamos sesión. La usaremos para mantener la etapa y el estado.
session_start();


/**
 * Solo cargamos el archivo .env si es que existe.
 * Si no existe se deben de usar las variables del servidor.
 */
if (file_exists(".env")) {
    $dotenv = new Dotenv();
    $dotenv->load(__DIR__ . '/.env');
}

//Etapa en la que va el proceso.
$stage = $_GET["stage"];

//Variable que usaremos para leer la respuesta de TOC
$finalResult = null;

//Clase con la que haremos las llamadas a TOC
$toc = new TOC();

/**
 * Manejamos la sesión para que dure 15 minutos. Tiempo que dura la sesión de TOC.
 * Creamos la sesión en TOC al iniciar y al renovar.
 */
if (!isset($_SESSION['created_at'])) {
    $_SESSION['created_at'] = time();
    $_SESSION['session_id'] = $toc->generateSessionId();
    $_SESSION["token-front"] = "";
    $_SESSION["token-back"] = "";
    $_SESSION["token-liveness"] = "";
} else if (time() - $_SESSION['created_at'] > 900 || $_GET["reset"] == true) {
    session_regenerate_id(true);
    $_SESSION['created_at'] = time();
    $_SESSION['session_id'] = $toc->generateSessionId();
    $_SESSION["token-front"] = "";
    $_SESSION["token-back"] = "";
    $_SESSION["token-liveness"] = "";
}

/**
 * Si es post guardamos los tokens resultados del Scan
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($stage) {
        //Si estamos en back, quiere decir que ya scaneamos front
        case "back" :
        {
            $_SESSION['token-front'] = $_POST["token-form"];
            print_r($_POST);
            break;
        }
        //Si estamos en la etapa de Selfie, quiere decir que recibimos token back
        case "liveness" :
        {
            $_SESSION['token-back'] = $_POST["token-form"];
            break;
        }
        //Si finalizamos quiere decir que terminamos el proceso
        case "finish" :
        {
            $_SESSION['token-liveness'] = $_POST["token-form"];
            break;
        }
    }
}

$session_id = $_SESSION['session_id'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Prueba FLujo TOC</title>
</head>
<body>

<div class="card text-center">
    <div class="card-header">
        Prueba de Flujo de TOC
    </div>
    <div class="card-body">
        <h5 class="card-title">Id Sesión utilizado : <?= $session_id ?></h5>
        <p class="card-text">Ejemplo burdo de como implementar la validación de TOC. Después de cada etapa haz click en siguiente.</p>

    </div>

</div>

<div class="container h-100">
    <div class="card" style="">

        <div class="card-body">

            <div class="card" style="">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Session Variable</th>
                        <th scope="col">Session Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($_SESSION as $key => $value) {
                        echo "<tr>";
                        echo "<td>$key</td>";
                        echo "<td>$value</td>";
                        echo "<tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="card" style="">
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">Post Variable</th>
                        <th scope="col">Post Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($_POST as $key => $value) {
                        echo "<tr>";
                        echo "<td>$key</td>";
                        echo "<td>$value</td>";
                        echo "<tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <?php
            switch ($stage) {
                case "front":
                {
                    include_once("_capture_front.php");
                    break;
                }
                case "back":
                {
                    include_once("_capture_back.php");
                    break;
                }
                case "liveness":
                {
                    include_once("_liveness.php");
                    break;
                }
                case "finish" :
                {
                    include_once("_result.php");
                    break;
                }
                default:
                {
                    include_once("_default.php");
                }
            }
            ?>
            <a href="/?reset=true" class="btn btn-primary">Reset</a>
        </div>
    </div>


    <!-- Content here -->
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>


</body>
</html>
