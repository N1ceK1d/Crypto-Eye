<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        
        <nav><a href="index.php">Crypto-EYE</a></nav>
        <nav><a href="pages/encrypt.php">Шифрование</a></nav>
        <nav><a href="pages/decrypt.php">Дешифрование</a></nav>
        <nav><a href="pages/hashing.php">Хэширование</a></nav>
        <?php
            session_start();
            $link = "";
            $text = "";
            if($_SESSION['login']) {
                $link = "pages/user.php";
                $text = "Профиль";
                echo "<nav><a href='$link'>$text</a></nav>";
            } else {
                $link = "pages/login.html";
                $text = "Войти";
                echo "<nav><a href='$link'>$text</a></nav>";
            }
        ?>
        
    </header>
</body>
</html>