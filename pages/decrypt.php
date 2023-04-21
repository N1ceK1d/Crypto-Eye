<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        require("../classes/AESCipher.php");
        require("../classes/RSACipher.php");
        $aes = new AESCipher();
        $rsa = new RSACipher();
    ?>
    <div>
        <form method="POST">
            <input placeholder="encrypt message" type="text" name="encrypt_message"/>
            <input placeholder="key" type="text" name="key"/>
            <input placeholder="iv" type="text" name="iv"/>
            <button name="decrypt">Расшифровать</button>
        </form>
        <div>
            <?php
                if (isset($_POST['decrypt'])) {
                    $encryptMessage = $_POST["encrypt_message"];
                    $encryptKey = $_POST["key"];
                    $ivValue = $_POST["iv"];

                    $decrypt = $aes->AesDecrypt($encryptMessage, $encryptKey, $ivValue);

                    echo "<p><b>encrypt message: </b>".$_POST["encrypt_message"]."</p>";
                    echo "<p><b>key: </b>".$_POST["key"]."</p>";
                    echo "<p><b>decrypt: </b>".$decrypt."</p>";
                }
            ?>
        </div>
    </div>
    <div>
        <form action="" method="POST">
            <textarea name="str"></textarea>
            <textarea name="privateKey"></textarea>
            <button name="decryptRSA">Расшифровать</button>
        </form>
        <div>
            <?php
                if(isset($_POST['decryptRSA'])) {
                    $privateKey = $_POST['privateKey'];
                    $str = $_POST['str'];
                    $rsa->RSADecrypt($str, $privateKey);
                }
            ?>
        </div>
    </div>
</body>
</html>