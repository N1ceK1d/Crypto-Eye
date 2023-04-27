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
        session_start();
        require("../modules/connect.php");
        require("../modules/sqlQuerys.php");
        require("menu.php");
    ?>
    <div class="user_container">
        <div class="user_info">
            <img src="">
            <h2><?php echo $_SESSION['login'];?></h2>
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
                        echo "<td>Строка</td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td>".$row['data_string']."</td>";
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
                        echo "<td>Ключ</td>";
                        echo "<td>IV</td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td>".$row['aes_key']."</td>";
                            echo "<td>".$row['aes_iv']."</td>";
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
                        echo "<td>Публичный ключ</td>";
                        echo "<td>Приватный ключ</td>";
                        echo "</tr>";
                        foreach($result as $row){
                            echo "<tr>";
                            echo "<td>".$row['public_key']."</td>";
                            echo "<td>".$row['private_key']."</td>";
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