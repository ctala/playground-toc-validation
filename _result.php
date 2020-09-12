<?php
$result = $toc->checkResult($_SESSION["token-front"], $_SESSION["token-back"], $_SESSION["token-liveness"]);
?>
<div>

    <div class="card border-success mb-3" style="width: 100%;">
        <div class="card-body text-success">
            <h5 class="card-title">Resultado</h5>
            <p class="card-text">
            <pre>
                    <?php
                    print_r(json_encode($result));
                    ?>
                </pre>

            </p>
        </div>
    </div>

</div>


