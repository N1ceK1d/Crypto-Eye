<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хэширование</title>
    <link rel="stylesheet" href="<? echo "../css/footer.css"?>">
    <link rel="stylesheet" href="<? echo "../css/pages.css"?>">
</head>
<body>
    <?php
        require("../classes/HashCipher.php");
        require("../classes/CipherFile.php");
        require("menu.php");
        $hash = new HashCipher();
        $cipher_file = new CipherFile();
    ?>
    <div class="hashing">
        <form action="" method="post">
            <textarea name="text"></textarea>
            <select class='hash_selecter' name="hash-algo">
                <option value="" defaultValue="true">Выберите алгоритм хэширования</option>
                <option value="SHA-512">SHA-512</option>
                <option value="SHA-256">SHA-256</option>
                <option value="MD5">MD5</option>
            </select>
            <button name="gethash">Хэшировать</button>
            <button name="exportHash">Экспортировать</button>
        </form>
        <div>
            <?php
               
                if(isset($_POST["gethash"])) {
                    $message = $_POST['text'];
                    $hashAlgo = $_POST['hash-algo'];
                    echo "<br>";
                    //в функцию hash передаём название алгоритма и сообщение
                    switch ($hashAlgo) {
                        case 'SHA-512':

                            $hash->setHash( hash("sha512", $message));
                            echo "<div class='encrypt-data'><h3>Информация</h3>";
                            echo "<p><b>Результат: </b>".$hash->getHash()."</p>";
                            break;
                        case 'SHA-256':
                            $hash->setHash( hash("sha256", $message));
                            echo "<div class='encrypt-data'><h3>Информация</h3>";
                            echo "<p><b>Результат: </b>".$hash->getHash()."</p>";
                            break;
                        case 'MD5':
                            $hash->setHash( hash("md5", $message));
                            echo "<div class='encrypt-data'><h3>Информация</h3>";
                            echo "<p><b>Результат: </b>".$hash->getHash()."</p>";
                            break;
                        default:
                            echo "<div class='encrypt-data'><h3>Информация</h3>";
                            echo "<p><b>Результат: </b>Введены неверные данные</p>";
                            break;
                    }
                    file_put_contents('text_files/hash.txt', $hash->getHash());
                }  
                if(isset($_POST['exportHash'])) {
                    $cipher_file->file_force_download('text_files/hash.txt');
                } 
            ?>
        </div>
    </div>
</body>
</html>