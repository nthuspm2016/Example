<?php
function ok($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3)=="200";
}
?>
