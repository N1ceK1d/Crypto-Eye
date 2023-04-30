<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./style.css" rel="stylesheet">
    <link rel="stylesheet" href="<? echo "../css/footer.css"?>">
    <link rel="stylesheet" href="<? echo "../css/pages.css"?>">
    <title>Шифрование</title>
</head>
<body>
    <?php 
        require("../classes/AESCipher.php");
        require("../classes/RSACipher.php");
        require("../classes/CipherFile.php");
        require("../modules/sqlQuerys.php");
        $aes = new AESCipher();
        $aesFile = new AESCipher();
        $rsa = new RSACipher();
        $rsaFile = new RSACipher();
        $cipher_file = new CipherFile();
        session_start();
        require("menu.php");
    ?>
    <div class="encrypt-content">
        <h1>AES Encrypt</h1>
        <form action="" method="POST">
            <textarea name="message"></textarea>
            <div class="buttons">
                <button name="encryptAES">Зашифровать</button>
                <button name="exportAES">Экспортировать шифротекст</button>
                <button name="export-data">Экспортировать данные</button>
            </div>
        </form>
        <div>
            <?php
                if(isset($_POST['encryptAES'])) {
                    $key = $aes->generateKey();
                    $aes->setMessage($_POST['message']);

                    $encrypt = $aes->AesEncrypt();

                    $iv = $aes->getIv();

                    echo "<div class='encrypt-data'><h3>Информация</h3>";
                    echo "<p><b>Ключ: </b>".$key."</p>";
                    echo "<p><b>Вектор инициализации: </b>".$iv."</p>";
                    echo "<p><b>Сообщение: </b>".$aes->getMessage()."</p>";
                    echo "<p><b>Результат: </b>".$encrypt."</p></div>";

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
            
                if($_SESSION["login"]) {
                    echo "<form action='' method='POST'>";
                    echo "<button name='saveData'>Сохранить данные</button>";
                    echo "</form>";
                }

                if(isset($_POST['saveData'])) {
                    $data = file_get_contents('text_files/aes/aes-data.txt');
                    $key = mb_substr(explode(' ', $data)[2], 0, -3);
                    $iv = explode(' ', $data)[4];
                    $aes_string = file_get_contents('text_files/aes/aes.txt');
                    saveAesData($_SESSION['login'], $key, $iv, $aes_string);
                }
            ?>
        </div>
        <h1>AES File Encrypt</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input__wrapper">
               <input name="filename" type="file" id="input__file" class="input input__file" multiple>
               <label for="input__file" class="input__file-button">
                  <span class="input__file-button-text">Выберите файл</span>
               </label>
            </div>
            <!--<input type="file" name="filename"/>-->
            <div class="buttons">
                <button name="encryptAESFile">Зашифровать файл</button>
                <button name="exportAESFile">Экспортировать шифротекст</button>
                <button name="export-file-data">Экспортировать данные</button>
            </div>
        </form>
        <div>
            <?php
                if(isset($_POST['encryptAESFile'])) {
                    if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK)
                    {
                        $name = $_FILES["filename"]["name"];
                        move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
                        rename($name, "text_files/aes/aes_file.txt");

                        $key = $aesFile->generateKey();
                        $aesFile->setMessage($_POST['message']);

                        $aesFile->AesEncryptFile();
                        
                        $iv = $aesFile->getIv();
                        echo "<div class='encrypt-data'><h3>Информация</h3>";
                        echo "<p><b>Ключ: </b>".$key."</p>";
                        echo "<p><b>Вектор инициализации:</b>".$iv."</p>";
                        //echo "<h3>INFO</h3>";
                        //echo "<p><b>key: </b>".$key."</p>";
                        //echo "<p><b>iv: </b>".$iv."</p>";
                        //echo "<p><b>message: </b>".$aesFile->getMessage()."</p>";

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

                if($_SESSION["login"]) {
                    echo "<form action='' method='POST'>";
                    echo "<button name='saveAesFileData'>Сохранить данные</button>";
                    echo "</form>";
                }

                if(isset($_POST['saveAesFileData'])) {
                    $data = file_get_contents('text_files/aes/aes-file-data.txt');
                    $key = mb_substr(explode(' ', $data)[2], 0, -3);
                    $iv = explode(' ', $data)[4];
                    $aes_string = file_get_contents('text_files/aes/aes_file.txt');
                    saveAesData($_SESSION['login'], $key, $iv, $aes_string);
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
                <div class="buttons">
                    <button name="encryptRSA">Зашифровать</button>
                    <button name="exportRSAKeys">Экспортировать ключи</button>
                    <button name="exportRSA">Экспортировать шифротекст</button>
                </div>
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
                        
                        echo "<div class='rsa_keys'><div><p class='key_type'>Публичный ключ</p><textarea>";
                        echo mb_substr($pubKey, 1, -1);
                        echo "</textarea></div>";

                        echo "<div><p class='key_type'>Привытный ключ</p>";
                        echo "<textarea>";
                        echo mb_substr($privKey, 1, -1);
                        echo "</textarea></div></div>";
                    }

                    if(isset($_POST['encryptRSA'])) {
                        $publicKey = $_POST['publicKey'];
                        $message = $_POST['message'];
                        $rsa_encrypt = $rsa->RSAEncrypt($message, $publicKey);
                        
                        file_put_contents('text_files/rsa/rsa.txt', $rsa_encrypt);

                        $homepage = file_get_contents('text_files/rsa/rsa.txt');
                        file_put_contents('text_files/rsa/rsa.txt', mb_substr($homepage, 1, -1));

                        echo "<h2>Результат</h2><textarea class='rsa-encrypt'>".mb_substr($homepage, 1, -1)."</textarea>";
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

                    if($_SESSION["login"]) {
                        echo "<form action='' method='POST'>";
                        echo "<button name='saveRsaKeys'>Сохранить ключи</button>";
                        echo "<button name='saveRsaString'>Сохранить строку</button>";
                        echo "</form>";
                    }
    
                    if(isset($_POST['saveRsaKeys'])) {
                        $privKey = file_get_contents('text_files/rsa/rsa-private.txt');
                        $publkey = file_get_contents('text_files/rsa/rsa-public.txt');
                        saveRsaKeys($_SESSION['login'], $publkey, $privKey);
                    }

                    if(isset($_POST['saveRsaString'])) {
                        $rsa_str = file_get_contents('text_files/rsa/rsa.txt');
                        saveRsaString($_SESSION['login'], $rsa_str);
                    }
                ?>
            </div>
        </div>
        <div>
            <h1>RSA Encrypt File</h1>
            <form action="" method="post" enctype="multipart/form-data">
                <input name="rsafile" type="file" class="rsa_file_input">
                <button name="generateRSAKeysFile">Сгенерировать ключи</button>
                <textarea name="publicKeyFile"></textarea>
                <div class="buttons">
                    <button name="encryptRSAFile">Зашифровать</button>
                    <button name="exportRSAKeysFile">Экспортировать ключи</button>
                    <button name="exportRSAFile">Экспортировать шифротекст</button>
                </div>
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

                        echo "<div class='rsa_keys'> <div> <p class='key_type'>Публичный ключ</p> <textarea>".mb_substr($pubKey, 1, -1)."</textarea> </div>";

                        echo "<div><p class='key_type'>Приватный ключ</p><textarea>".mb_substr($privKey, 1, -1)."</textarea></div></div>";
                    }

                    if(isset($_POST['encryptRSAFile'])) {
                        if ($_FILES && $_FILES["rsafile"]["error"] == UPLOAD_ERR_OK)
                        {
                            $name = $_FILES["rsafile"]["name"];
                            move_uploaded_file($_FILES["rsafile"]["tmp_name"], $name);
                            rename($name, "text_files/rsa/rsa_file.txt");
                            $publicKey = $_POST['publicKeyFile'];
                            $message = file_get_contents('text_files/rsa/rsa_file.txt');
                            $rsa_encrypt = $rsa->RSAEncrypt($message, $publicKey);
                            file_put_contents('text_files/rsa/rsa_file_encrypt.txt', mb_substr($rsa_encrypt, 1, -1));
                            echo "<h2>Результат</h2><textarea class='rsa-encrypt'>".mb_substr($rsa_encrypt, 1, -1)."</textarea>";
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

                    if($_SESSION["login"]) {
                        echo "<form action='' method='POST'>";
                        echo "<button name='saveRsaFileKeys'>Сохранить ключи</button>";
                        echo "</form>";
                        echo "<form action='' method='POST'>";
                        echo "<button name='saveRsaFileString'>Сохранить строку</button>";
                        echo "</form>";
                    }
    
                    if(isset($_POST['saveRsaFileKeys'])) {
                        $privKey = file_get_contents('text_files/rsa/rsa-private-file.txt');
                        $publkey = file_get_contents('text_files/rsa/rsa-public-file.txt');
                        saveRsaKeys($_SESSION['login'], $publkey, $privKey);
                    }

                    if(isset($_POST['saveRsaFileString'])) {
                        $rsa_str = file_get_contents('text_files/rsa/rsa_file_encrypt.txt');
                        saveRsaString($_SESSION['login'], $rsa_str);
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>