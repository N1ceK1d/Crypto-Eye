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
        require("../classes/CipherFile.php");
        $aes = new AESCipher();
        $rsa = new RSACipher();
        $cipher_file = new CipherFile();
    ?>
    <div>
        <h1>AES Encrypt</h1>
        <form action="" method="POST">
            <textarea name="message"></textarea>
            <button name="encryptAES">Зашифровать</button>
            <button name="exportAES">Экспортировать шифротекст</button>
            <button name="export-data">Экспортировать данные</button>
        </form>
        <div>
            <h1>RSA Encrypt</h1>
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

                    $aes_data = "ИНФОРМАЦИЯ:\nKey - $key\nIV - $iv";

                    file_put_contents('text_files/aes.txt', $encrypt);
                    file_put_contents('text_files/aes-data.txt', $aes_data);
                }

                if(isset($_POST['exportAES'])) {
                    $cipher_file->file_force_download('text_files/aes.txt');
                }

                if(isset($_POST['export-data'])) {
                    $cipher_file->file_force_download('text_files/aes-data.txt');
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
                <button name="exportRSAKeys">Экспортировать ключи</button>
                <button name="exportRSA">Экспортировать шифротекст</button>
            </form>
            <div>
                <?php
                    if(isset($_POST['generateRSAKeys'])) {
                        $rsa->generateKeys();

                        $pubKey = $rsa->getPublicKey();
                        $privKey = $rsa->getPrivateKey();

                        file_put_contents('text_files/rsa-public.txt', $pubKey);
                        file_put_contents('text_files/rsa-private.txt', $privKey);

                        $pubKey = file_get_contents('text_files/rsa-public.txt');
                        file_put_contents('text_files/rsa-public.txt', mb_substr($pubKey, 1, -1));

                        $privKey = file_get_contents('text_files/rsa-private.txt');
                        file_put_contents('text_files/rsa-private.txt', mb_substr($privKey, 1, -1));

                        echo "<p>Публичный ключ</p>";
                        echo "<pre class='rsa-public key'>";
                        echo mb_substr($pubKey, 1, -1);
                        echo "</pre>";

                        echo "<p>Привытный ключ</p>";
                        echo "<pre class='rsa-private key'>";
                        echo mb_substr($privKey, 1, -1);
                        echo "</pre>";
                    }

                    if(isset($_POST['encryptRSA'])) {
                        $publicKey = $_POST['publicKey'];
                        $message = $_POST['message'];
                        $rsa_encrypt = $rsa->RSAEncrypt($message, $publicKey);
                        
                        file_put_contents('text_files/rsa.txt', $rsa_encrypt);

                        $homepage = file_get_contents('text_files/rsa.txt');
                        file_put_contents('text_files/rsa.txt', mb_substr($homepage, 1, -1));

                        echo mb_substr($homepage, 1, -1);
                    }

                    if(isset($_POST['exportRSAKeys'])) {

                        $zip = new ZipArchive(); 
                        $zip->open("text_files/RSA_keys.zip", ZIPARCHIVE::CREATE);
                        $zip->addFile("text_files/rsa-public.txt");
                        $zip->addFile("text_files/rsa-private.txt");
                        $zip->close();

                        $cipher_file->file_force_download('text_files/RSA_keys.zip');
                    }
    
                    if(isset($_POST['exportRSA'])) {
                        $cipher_file->file_force_download('text_files/rsa.txt');
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>