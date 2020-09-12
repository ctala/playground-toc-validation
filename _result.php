<?php
$result = $toc->checkResult($_SESSION["token-front"], $_SESSION["token-back"], $_SESSION["token-liveness"]);
?>
<div>

    <div class="card border-success mb-3" style="width: 20rem;">
        <div class="card-body text-success">
            <h5 class="card-title">Resultado</h5>
            <p class="card-text">
            <pre><code>
                    <?php

                    print_r($result);
                    ?>
                </code>

            </pre></p>
        </div>
    </div>

</div>


