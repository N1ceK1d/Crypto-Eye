<?php
require("../modules/connect.php");

$login = $_POST['login'];
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

$registerQuery = "INSERT INTO Users (Users.login, Users.password_hash) 
VALUES ('$login', '$password_hash');";

if ($conn->query($registerQuery) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $registerQuery . "<br>" . $conn->error;
}
$conn->close();
header("Location: login.html");
?>