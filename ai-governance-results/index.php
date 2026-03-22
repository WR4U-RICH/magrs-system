<?php

$id = $_GET['id'] ?? '';

header("Location: /magrs/results/?id=" . urlencode($id));
exit;