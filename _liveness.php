<?php

?>

<p class="card-text">Scaniamos tu rostro para saber que no eres un ROBOT</p>
<div id="liveness"></div>

<form action="?stage=finish" method="post">
    <input type="text" id="token-form" name="token-form" value="">
    <input type="submit" value="Siguiente" class="btn btn-primary">
</form>

<script src="https://sandbox-web-plugins.s3.amazonaws.com/liveness/js/liveness.js"></script>
<script src="assets/js/TOC.js"></script>
<script>
    let session_id = "<?="$session_id"?>";
    tocLiveness(session_id);
</script>