<?php
    include '../config/connectDB.php';
    include '../others/checkpass.php';
    $isDark = false;
    if(isset($_COOKIE['isDark'])){
        $isDark = $_COOKIE['isDark'];
    }
    $conn = connectDB();
    $allowPassword = true;
    $passMatched = true;
        $email = "";
        if(isset($_COOKIE['email']))
            $email = $_COOKIE['email'];

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(!$email)
                $email = $_POST['email'];
            $password = $_POST['password'];
            $conPass = $_POST['conPass'];
            $allowPassword = checkPasswordStrength($password);
            if($allowPassword){
                if($conPass === $password){
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
                    $conn -> query($sql);
                    header('Location: ../../auth/logout.php');
                }else{
                    $passMatched = false;
                }
            }
        }
   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/theme.css">
</head>

<body class= <?php if($isDark) echo "'dark'"; else echo "'light'"; ?> >
    <main class='form-wrapper'>
        <form action='' method='post' class='login-signup'>
            <h2>Reset Password</h2>
            <div class='inputs'>
                <input type='email' name='email' id='email' class='inp-light' value='<?php if($email != "") { echo $email; ?>' <?php echo 'disabled';} ?>  placeholder='Email' required>
                <input type='password' name='password' id='password' class='inp-light' placeholder='Password' required>
                <input type='password' name='conPass' id='conPass' class='inp-light' placeholder='Confirm Password' required>
                <?php
                    if(!$passMatched){
                        echo "<p class='warning' style='color: red; font-weight: 600; text-align: left;'>Password not matched!</p>";
                    }
                    if(!$allowPassword){
                        echo "<p class='warning' style='color: red; font-weight: 600; text-align: left;'>Please use a strong password!</p>";
                    }
                ?>
            </div><br>
            <button class='btn-light submit-btns' type='submit'>Reset Password</button>
        </form>
    </main>
    <script src="../js/script.js"></script>
</body>
</html>