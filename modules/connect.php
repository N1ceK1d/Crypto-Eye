<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "CryptoEye";

$conn = new mysqli($host, $user, $password, $db);

if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}

echo "Подключение успешно установлено\n";


?>