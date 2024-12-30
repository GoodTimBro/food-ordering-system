<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "order_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("連線失敗：" . $conn->connect_error);
}
?>
