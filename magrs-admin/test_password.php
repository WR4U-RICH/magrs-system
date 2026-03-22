<?php

$password = "P@$$4Magrs";
$hash = "$2y$10$vA9hVidxNT86pBmopyk97Oa1DVaH8X0.Y6Gkf4Tx9a910BLeTAesG";

if (password_verify($password, $hash)) {
    echo "PASSWORD MATCHES";
} else {
    echo "PASSWORD DOES NOT MATCH";
}
?>