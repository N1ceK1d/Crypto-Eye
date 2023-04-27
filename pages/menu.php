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
        <nav><a href="../index.php">Crypto-EYE</a></nav>
        <nav><a href="encrypt.php">Шифрование</a></nav>
        <nav><a href="decrypt.php">Дешифрование</a></nav>
        <nav><a href="hashing.php">Хэширование</a></nav>
        <?php
            session_start();
            $link = "";
            $text = "";
            if($_SESSION['login']) {
                $link = "user.php";
                $text = "Профиль";
                echo "<nav><a href='$link'>$text</a></nav>";
            }
        ?>
    </header>
</body>
</html>