<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo "../css/menu.css"; ?>">
</head>
<body>
    <header>
        <a href="../index.php"><img class="logo" src="../images/logo.png" alt=""></a>
        <nav><a href="encrypt.php">Шифрование</a>
        <a href="decrypt.php">Дешифрование</a>
        <a href="hashing.php">Хэширование</a>
        <?php
            session_start();
            $link = "";
            $text = "";
            if($_SESSION['login']) {
                $link = "user.php";
                $text = "Профиль";
                echo "<a href='$link'>$text</a></nav>";
            } else {
                $link = "login.html";
                $text = "Войти";
                echo "<a href='$link'>$text</a></nav>";
            }
        ?>
    </header>
</body>
</html>