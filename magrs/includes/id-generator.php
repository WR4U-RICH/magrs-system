<?php

function generate_magrs_id() {

    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $length = 5;

    $random = '';

    for ($i = 0; $i < $length; $i++) {
        $random .= $characters[random_int(0, strlen($characters) - 1)];
    }

    return 'MAGRS-' . $random;
}

?>