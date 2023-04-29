<?php
    require("../modules/connect.php");

    $login = $_POST['ulogin'];
    $sql = "SELECT login FROM `Users` WHERE login = '$login'";

    $res = $conn->query($sql);
    $row = $res->fetch_row();
    $count = $row[0];

    if($count) {
        echo "Такой пользователь уже есть";
    }else {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $registerQuery = "INSERT INTO Users (Users.login, Users.password_hash) 
        VALUES ('$login', '$password_hash');";

        if ($conn->query($registerQuery) === TRUE) {
            echo "New record created successfully";
            header("Location: login.html");
        } else {
            echo "Error: " . $registerQuery . "<br>" . $conn->error;
        }
        $conn->close();
    }

    ?>