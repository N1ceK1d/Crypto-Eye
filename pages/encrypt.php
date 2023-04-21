<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
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
        <form action="" method="POST">
            <textarea name="message"></textarea>
            <button name="encryptAES">Зашифровать</button>
        </form>
        <div>
            <?php
                if(isset($_POST['encryptAES'])) {
                    $key = $aes->generateKey();
                    $aes->setMessage($_POST['message']);

                    $encrypt = $aes->AesEncrypt();

                    $iv = $aes->getIv();

                    echo "<h3>INFO</h3>";
                    echo "<p><b>key: </b>".$key."</p>";
                    echo "<p><b>iv: </b>".$iv."</p>";
                    echo "<p><b>message: </b>".$aes->getMessage()."</p>";
                    echo "<p><b>encrypt: </b>".$encrypt."</p>";
                }
            ?>
        </div>
    </div>
    <div>
        <div>
            <form action="" method="POST">
                <button name="generateRSAKeys">Сгенерировать ключи</button>
                <textarea name="message"></textarea>
                <textarea name="publicKey"></textarea>
                <button name="encryptRSA">Зашифровать</button>
            </form>
            <div>
                <?php
                    if(isset($_POST['generateRSAKeys'])) {
                        $rsa->generateKeys();
                        echo "<p>Публичный ключ</p>";
                        echo "<pre class='rsa-public key'>";
                        $rsa->getPublicKey();
                        echo "</pre>";
                        echo "<p>Привытный ключ</p>";
                        echo "<pre class='rsa-private key'>";
                        $rsa->getPrivateKey();
                        echo "</pre>";
                    }
                    if(isset($_POST['encryptRSA'])) {
                        $publicKey = $_POST['publicKey'];
                        $message = $_POST['message'];
                        $rsa->RSAEncrypt($message, $publicKey);
                    }
                
                ?>
            </div>
        </div>
    </div>
</body>
</html>