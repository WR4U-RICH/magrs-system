<?php
require 'auth.php';
?>

<!DOCTYPE html>
<html>
<head>

<title>MAGRS Admin Console</title>

<style>

body {
    font-family: Arial, Helvetica, sans-serif;
    margin: 40px;
}

nav {
    margin-bottom: 25px;
}

nav a {
    margin-right: 15px;
    text-decoration: none;
    font-weight: bold;
}

nav a:hover {
    text-decoration: underline;
}

</style>

</head>

<body>

<h1>MAGRS Admin Console</h1>

<nav>
<a href="dashboard.php">Dashboard</a>
<a href="create_org.php">Create Organization</a>
<a href="logout.php">Logout</a>
</nav>

<hr>