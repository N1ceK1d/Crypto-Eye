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
        $aesFile = new AESCipher();
        $rsa = new RSACipher();
        $rsaFile = new RSACipher();
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

                    file_put_contents('text_files/aes/aes.txt', $encrypt);
                    file_put_contents('text_files/aes/aes-data.txt', $aes_data);
                }

                if(isset($_POST['exportAES'])) {
                    $cipher_file->file_force_download('text_files/aes/aes.txt');
                }

                if(isset($_POST['export-data'])) {
                    $cipher_file->file_force_download('text_files/aes/aes-data.txt');
                }
            ?>
        </div>
        <h1>AES File Encrypt</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="filename"/>
            <button name="encryptAESFile">Зашифровать файл</button>
            <button name="exportAESFile">Экспортировать шифротекст</button>
            <button name="export-file-data">Экспортировать данные</button>
        </form>
        <div>
            <?php
                if(isset($_POST['encryptAESFile'])) {
                    if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK)
                    {
                        $name = $_FILES["filename"]["name"];
                        move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
                        rename($name, "text_files/aes/aes_file.txt");
                        echo "Файл загружен";

                        $key = $aesFile->generateKey();
                        $aesFile->setMessage($_POST['message']);

                        $aesFile->AesEncryptFile();
                        
                        $iv = $aesFile->getIv();

                        echo "<h3>INFO</h3>";
                        echo "<p><b>key: </b>".$key."</p>";
                        echo "<p><b>iv: </b>".$iv."</p>";
                        echo "<p><b>message: </b>".$aesFile->getMessage()."</p>";

                        $aes_data = "ИНФОРМАЦИЯ:\nKey - $key\nIV - $iv";

                        file_put_contents('text_files/aes/aes-file-data.txt', $aes_data);
                    }
                }
                
                if(isset($_POST['exportAESFile'])) {
                    $cipher_file->file_force_download('text_files/aes/aes_file.txt');
                }

                if(isset($_POST['export-file-data'])) {
                    $cipher_file->file_force_download('text_files/aes/aes-file-data.txt');
                }
            ?>
        </div>
    </div>
    <div>
        <div>
            <h1>RSA Encrypt</h1>
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

                        file_put_contents('text_files/rsa/rsa-public.txt', $pubKey);
                        file_put_contents('text_files/rsa/rsa-private.txt', $privKey);

                        $pubKey = file_get_contents('text_files/rsa/rsa-public.txt');
                        file_put_contents('text_files/rsa/rsa-public.txt', mb_substr($pubKey, 1, -1));

                        $privKey = file_get_contents('text_files/rsa/rsa-private.txt');
                        file_put_contents('text_files/rsa/rsa-private.txt', mb_substr($privKey, 1, -1));

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

                        $homepage = file_get_contents('text_files/rsa/rsa.txt');
                        file_put_contents('text_files/rsa/rsa.txt', mb_substr($homepage, 1, -1));

                        echo mb_substr($homepage, 1, -1);
                    }

                    if(isset($_POST['exportRSAKeys'])) {

                        $zip = new ZipArchive(); 
                        $zip->open("text_files/rsa/RSA_keys.zip", ZIPARCHIVE::CREATE);
                        $zip->addFile("text_files/rsa/rsa-public.txt");
                        $zip->addFile("text_files/rsa/rsa-private.txt");
                        $zip->close();

                        $cipher_file->file_force_download('text_files/rsa/RSA_keys.zip');
                    }
    
                    if(isset($_POST['exportRSA'])) {
                        $cipher_file->file_force_download('text_files/rsa/rsa.txt');
                    }
                ?>
            </div>
        </div>
        <div>
            <h1>RSA Encrypt Fiel</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="rsafile" id="">
                <button name="generateRSAKeysFile">Сгенерировать ключи</button>
                <textarea name="publicKeyFile"></textarea>
                <button name="encryptRSAFile">Зашифровать</button>
                <button name="exportRSAKeysFile">Экспортировать ключи</button>
                <button name="exportRSAFile">Экспортировать шифротекст</button>
            </form>
            <div>
                <?php
                    if(isset($_POST['generateRSAKeysFile'])) {
                        $rsaFile->generateKeys();

                        $pubKey = $rsaFile->getPublicKey();
                        $privKey = $rsaFile->getPrivateKey();

                        file_put_contents('text_files/rsa/rsa-public-file.txt', $pubKey);
                        file_put_contents('text_files/rsa/rsa-private-file.txt', $privKey);

                        $pubKey = file_get_contents('text_files/rsa/rsa-public-file.txt');
                        file_put_contents('text_files/rsa/rsa-public-file.txt', mb_substr($pubKey, 1, -1));

                        $privKey = file_get_contents('text_files/rsa/rsa-private-file.txt');
                        file_put_contents('text_files/rsa/rsa-private-file.txt', mb_substr($privKey, 1, -1));

                        echo "<p>Публичный ключ</p>";
                        echo "<pre class='rsa-public key'>";
                        echo mb_substr($pubKey, 1, -1);
                        echo "</pre>";

                        echo "<p>Привытный ключ</p>";
                        echo "<pre class='rsa-private key'>";
                        echo mb_substr($privKey, 1, -1);
                        echo "</pre>";
                    }

                    if(isset($_POST['encryptRSAFile'])) {
                        if ($_FILES && $_FILES["rsafile"]["error"] == UPLOAD_ERR_OK)
                        {
                            $name = $_FILES["rsafile"]["name"];
                            move_uploaded_file($_FILES["rsafile"]["tmp_name"], $name);
                            rename($name, "text_files/rsa/rsa_file.txt");
                            echo "Файл загружен";
                            $publicKey = $_POST['publicKeyFile'];
                            $message = file_get_contents('text_files/rsa/rsa_file.txt');
                            $rsa_encrypt = $rsa->RSAEncrypt($message, $publicKey);
                            file_put_contents('text_files/rsa/rsa_file_encrypt.txt', mb_substr($rsa_encrypt, 1, -1));
                            echo mb_substr($rsa_encrypt, 1, -1);
                        }
                    }

                    if(isset($_POST['exportRSAKeysFile'])) {

                        $zip = new ZipArchive(); 
                        $zip->open("text_files/rsa/RSA_file_keys.zip", ZIPARCHIVE::CREATE);
                        $zip->addFile("text_files/rsa/rsa-public-file.txt");
                        $zip->addFile("text_files/rsa/rsa-private-file.txt");
                        $zip->close();

                        $cipher_file->file_force_download('text_files/rsa/RSA_file_keys.zip');
                    }
    
                    if(isset($_POST['exportRSAFile'])) {
                        $cipher_file->file_force_download('text_files/rsa/rsa_file_encrypt.txt');
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>