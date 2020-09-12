<?php
$result = $toc->checkResult($_SESSION["token-front"], $_SESSION["token-back"], $_SESSION["token-liveness"]);
echo "<pre><code>";
print_r($result);
echo "</code></pre>";