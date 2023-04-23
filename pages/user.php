<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php
        require("../modules/connect.php");
        $query = "SELECT 
        Users.id, Users.login,
        AES_data.aes_key, AES_data.aes_iv,
        RSA_keys.keyType, RSA_keys.keyString,
        UserData.data_string
        FROM Users 
        INNER JOIN AES_data ON AES_data.user_id = Users.id
        INNER JOIN RSA_keys ON RSA_keys.user_id = Users.id
        INNER JOIN UserData ON UserData.user_id = Users.id
        ;";
        $selectAes = "SELECT AES_data.id, AES_data.aes_key, AES_data.aes_iv
        FROM AES_data;";
    ?>
    <div class="user_container">
        <div class="user_info">
            <img src="">
            <h2><?php ?></h2>
            <form action="" method="post">
                <button name="exit">Выйти</button>
            </form>
        </div>
    </div>
</body>
</html>