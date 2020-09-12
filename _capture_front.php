<?php

?>

<p class="card-text">Scaniamos el ID por el Frente</p>
<div id="scan-front"></div>

<form action="?stage=back" method="post">
    <input type="text" id="token-form" name="token-form" value="">
    <input type="submit" value="Siguiente" class="btn btn-primary">
</form>

<script src="https://sandbox-web-plugins.s3.amazonaws.com/autocapture/autocapture.js"></script>
<script src="assets/js/TOC.js"></script>
<script>
    let session_id = "<?="$session_id"?>";
    tocCapture(session_id,"front","scan-front");
</script>