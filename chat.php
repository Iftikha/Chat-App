
<?php
// 
    include "./assets/config/connectDB.php";
    $conn = connectDB();
    $isDark = false;
    if(isset($_COOKIE['isDark'])){
        $isDark = $_COOKIE['isDark'];
    }
    $imagePath = "assets/images/pfp/defaul-user.png";
    if(isset($_GET['user'])){
        $username = $_GET['user'];
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);
        if($result -> num_rows != 0){
            $row = $result -> fetch_assoc();
            if($row['pfp_path'] != ""){
                $imagePath = $row['pfp_path'];
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat with <?= $username; ?></title>
        <link rel="stylesheet" href="./assets/css/style.css">
        <link rel="stylesheet" href="./assets/css/theme.css">
    </head>
    <body class="<?php if($isDark) echo 'dark'; else echo 'light'; ?>">
        <section class="chat-body">
        <header class="chat-Header">
            <div class="back"><a href="index.php"><button class="btn-light small-btns"><img src="./assets/images/icons/back-arrow.png" alt=""></button></a></div>
            <div class="pfp leftContact">
                <img src="./<?= $imagePath; ?>" alt="">
            </div>
            <div class="username contactName"><h4><?= $username; ?></h4></div>
        </header>
        
        <main class="msgs">

        <!-- All the msgs will be displayed here, recieving msg class name = "msg rec" and sending msg class name = "msg sent". -->
        
        </main>
        <footer class="sender">
            <form class="message-form" method="post">
                <input type="text" name="sender" id="sender"  class="hidden" value="<?= $_COOKIE['name']; ?>">
                <input type="text" name="text-msg" id="text-msg" class="text-msg" placeholder="Type anything here" required>
                <input type="text" name="reciever" id="reciever" class="hidden" value="<?= $username;?>">
                <button class="btn-light small-btns send-btn" type="submit"><img src="assets/images/icons/send-icon.png" alt=""></button>
            </form>
        </footer>
    </section>
    
    <script src="assets/js/chat-ajax.js"></script>
</body>
</html>