<?php

?>

<p class="card-text">Scaniamos el ID por atrás</p>

<div id="scan-back"></div>

<form action="?stage=liveness" method="post">
    <input type="text" id="token-form" name="token-form" value="">
    <input type="submit" value="Siguiente" class="btn btn-primary">
</form>

<script src="https://sandbox-web-plugins.s3.amazonaws.com/autocapture/autocapture.js"></script>
<script src="assets/js/TOC.js"></script>
<script>
    let session_id = "<?="$session_id"?>";
    tocCapture(session_id,"back","scan-back");
</script>