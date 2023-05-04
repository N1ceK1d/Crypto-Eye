<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
    <link rel="stylesheet" href="<? echo "../css/footer.css"?>">
    <link rel="stylesheet" href="<? echo "../css/user.css"?>">
</head>
<body>
    <?php
        session_start();
        require("../modules/connect.php");
        require("../modules/sqlQuerys.php");
        require("menu.php");
    ?>
    <div class="user_container">
        <div class="user_info">
            <img class='profile-img' src="../images/logo.png">
            <h2 class="username"><?php echo $_SESSION['login'];?></h2>
            <?php
                if($_SESSION['login']) {
                    echo "<form action='' method='post'>";
                    echo "<button name='exit'>Выйти</button>";
                    echo "</form>";
                } else {
                    echo "<a href='login.html'>Войдите</a>";
                }
            ?>
        </div>
        <div class="user-data">
        <div class="user-strings">
                <?php
                    $userId = findUser($_SESSION["login"]);
                    $sql = "SELECT data_string FROM UserData WHERE user_id = $userId;";
                    $login = "";
                    
                    if($result = $conn->query($sql)){
                        echo "<table>";
                        echo "<tr>";
                        echo "<td><b>Строка</b></td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td class='aes-item'><textarea class='row-item'>".$row['data_string']."</textarea></td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                ?>
            </div>
            <div class="user-aes-data">
                <?php
                    $userId = findUser($_SESSION["login"]);
                    $sql = "SELECT aes_key, aes_iv FROM AES_data WHERE user_id = $userId;";
                    $login = "";
                    
                    if($result = $conn->query($sql)){
                        echo "<table>";
                        echo "<tr>";
                        echo "<td><b>Ключи</b></td>";
                        echo "<td><b>Векторы инициализации</b></td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td class='aes-item aes-keys'><textarea>".$row['aes_key']."</textarea></td>";
                            echo "<td class='aes-item'>".$row['aes_iv']."</td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                ?>
            </div>
            <div class="user-rsa-keys">
                <?php
                    $userId = findUser($_SESSION["login"]);
                    $sql = "SELECT public_key, private_key FROM RSA_keys WHERE user_id = $userId;";
                    $login = "";
                    
                    if($result = $conn->query($sql)){
                        echo "<table>";
                        echo "<tr>";
                        echo "<td><b>Публичные ключи</b></td>";
                        echo "<td><b>Приватные ключи</b></td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td><textarea class='aes-item'>".$row['public_key']."</textarea></td>";
                            echo "<td><textarea class='aes-item'>".$row['private_key']."</textarea></td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                ?>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['exit'])) {
            session_destroy();
            header("Location: ../index.php");
        }
        $conn->close();
    ?>
</body>
</html>