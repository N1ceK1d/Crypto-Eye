<?php

function findUser($login) {
    require("connect.php");

    $sql = "SELECT id FROM Users WHERE login = '$login';";
    $login = "";
    if($result = $conn->query($sql)){
        foreach($result as $row){
            $login = $row['id'];
        }
    }
    $conn->close();
    return $login;
} 

function saveAesData($login, $key, $iv, $aes_string) {
    require("connect.php");

    $user = findUser($login);
    $sql = "INSERT INTO AES_data (user_id, aes_key, aes_iv) 
    VALUES ( $user, '$key', '$iv');";
    $res = $conn->query($sql);

    $sql = "INSERT INTO UserData (user_id, data_string) 
    VALUES ( $user, '$aes_string');";
    $res = $conn->query($sql);

    $conn->close();
}

function saveRsaKeys($login, $public_key, $private_key) {
    require("connect.php");

    $user = findUser($login);
    $sql = "INSERT INTO RSA_keys (user_id, public_key, private_key) 
    VALUES ( $user, '$public_key', '$private_key');";
    $res = $conn->query($sql);

    $conn->close();
}

function saveRsaString($login, $rsa_string) {
    require("connect.php");

    $user = findUser($login);

    $sql = "INSERT INTO UserData (user_id, data_string) 
    VALUES ( $user, '$rsa_string');";
    $res = $conn->query($sql);

    $conn->close();
}

?>