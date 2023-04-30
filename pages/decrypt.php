<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дешифрование</title>
    <link rel="stylesheet" href="<?php echo "../css/pages.css"?>">
</head>
<body>
    <?php
        require("../classes/AESCipher.php");
        require("../classes/RSACipher.php");
        require("../classes/CipherFile.php");
        require("menu.php");
        $aes = new AESCipher();
        $rsa = new RSACipher();
        $aesFile = new AESCipher();
        $rsaFile = new RSACipher();
        $cipher_file = new CipherFile();
    ?>
    <div class="encrypt-content">
        <h1>AES Decrypt</h1>
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
                    echo "<div class='encrypt-data'><h3>Информация</h3>";
                    echo "<p><b>Результат: </b>".$decrypt."</p></div>";
                    //echo "<p><b>encrypt message: </b>".$_POST["encrypt_message"]."</p>";
                    //echo "<p><b>key: </b>".$_POST["key"]."</p>";
                    //echo "<p><b>decrypt: </b>".$decrypt."</p>";
                }
            ?>
        </div>
        <h1>AES File Decrypt</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="input__wrapper">
               <input name="encrypt_filename" type="file" id="input__file" class="input input__file" multiple>
               <label for="input__file" class="input__file-button">
                  <span class="input__file-button-text">Выберите файл</span>
               </label>
            </div>
            <!--<input type="file" name="encrypt_filename"/>-->
            <input placeholder="key" type="text" name="key-file"/>
            <input placeholder="iv" type="text" name="iv-file"/>
            <button name="decryptFile">Расшифровать</button>
        </form>
        <div>
            <?php
                if(isset($_POST['decryptFile'])) {
                    if ($_FILES && $_FILES["filename"]["error"] == UPLOAD_ERR_OK)
                    {
                        $name = $_FILES["encrypt_filename"]["name"];
                        move_uploaded_file($_FILES["encrypt_filename"]["tmp_name"], $name);
                        rename($name, "text_files/aes/aes_enc_file.txt");

                        $key = $aesFile->generateKey();
                        $aesFile->setMessage($_POST['message']);

                        $encrypt = $aesFile->AesEncrypt();

                        $iv = $aesFile->getIv();

                        $encryptKey = $_POST["key-file"];
                        $ivValue = $_POST["iv-file"];

                        $decrypt = $aes->AesDecryptFile($encryptKey, $ivValue);
                        $file = file_get_contents('text_files/aes/aes_decrypt_file.txt');
                        echo "<div class='encrypt-data'><h3>Информация</h3>";
                        echo "<p><b>Результат: </b>".$file."</p></div>";
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
        <h1>RSA Decrypt</h1>
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
                    $decrypt = $rsa->RSADecrypt($str, $privateKey);
                    echo "<div class='encrypt-data'><h3>Информация</h3>";
                    echo "<p><b>Результат: </b>".$decrypt."</p></div>";
                }
            ?>
        </div>
    </div>
    <div>
        <h1>RSA Decrypt File</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="enc_rsa_files" class="rsa_file_input">
            <textarea name="rsa_private_key"></textarea>
            <button name="decrypt_rsa_file">Расшифровать файл</button>
        </form>
        <div>
            <?php
                if(isset($_POST['decrypt_rsa_file'])) {
                    if ($_FILES && $_FILES["enc_rsa_files"]["error"] == UPLOAD_ERR_OK)
                    {
                        $name = $_FILES["enc_rsa_files"]["name"];
                        move_uploaded_file($_FILES["enc_rsa_files"]["tmp_name"], $name);
                        rename($name, "text_files/rsa/encrypted_rsa_file.txt");

                        $privateKey = $_POST['rsa_private_key'];
                        $message = file_get_contents('text_files/rsa/encrypted_rsa_file.txt');
                        $rsa_encrypt = $rsaFile->RSADecrypt($message, $privateKey);
                        file_put_contents('text_files/rsa/encrypted_rsa_file.txt', mb_substr($rsa_encrypt, 1, -1));
                        echo "<div class='encrypt-data'><h3>Информация</h3>";
                        echo "<p><b>Результат: </b>".mb_substr($rsa_encrypt, 1, -1)."</p></div>";
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>