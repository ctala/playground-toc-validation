<?php
$actual_link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$qrCodeUrl = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=$actual_link"
?>

<p class="card-text">Continua con el Celular : <img src="<?=$qrCodeUrl?>"></p>
<a href="/?stage=front" class="btn btn-primary">Iniciar</a>