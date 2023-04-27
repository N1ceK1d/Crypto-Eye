<?php
require("../modules/connect.php");

$login = $_POST['login'];
$password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

//echo $_POST['login'];
$sql = "SELECT login, password_hash FROM Users WHERE Users.login = '$login';";
if($result = $conn->query($sql)){
    foreach($result as $row){
        $pass = $row["password_hash"];
        if (password_verify($_POST['password'], $pass)) {
            echo 'Пароль правильный!';
            session_start();
            $_SESSION["login"] = $row["login"];
            echo $_SESSION["login"];
            header("Location: user.php");
        } else {
            echo 'Пароль неправильный.';
        }
    }
}

$conn->close();
?>