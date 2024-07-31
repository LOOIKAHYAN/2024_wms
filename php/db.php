<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "2024_wms";

$conn = mysqli_connect($hostname, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbname";

if (mysqli_query($conn, $sql)) {
    mysqli_select_db($conn, $dbname);
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

?>