<?php
    include './assets/config/connectDB.php';
    include './assets/others/checkpass.php';
    $isDark = false;
    if(isset($_COOKIE['isDark'])){
        $isDark = $_COOKIE['isDark'];
    }
    $isLoggedin = false;
    $passMatched = true;
    $emailExists = false;
    $usernameAvailable = true;
    $allowPassword = true;
    $conn = connectDB();
    // echo("Worked");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $conPass = $_POST['conPass'];
        $username = $_POST['username'];
        $allowPassword = checkPasswordStrength($password);
            if($allowPassword){

                
                if($password == $conPass){
                $passMatched = true;
                $sql = "SELECT * FROM users WHERE email = '$email'";
                $result = $conn->query($sql);
                
                if($result -> num_rows == 0){
                    $sql = "SELECT * FROM users WHERE username = '$username'";
                    $result = $conn->query($sql);
    
                    if($result -> num_rows == 0){
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO `users` (`email`, `username`, `password`, `joined`) VALUES ('$email', '$username', '$hashedPassword', current_timestamp());";
                        if($conn->query($sql)){
                            setcookie('email', $email, time() + 3600, "/");
                            setcookie('name', $username, time() + 3600, "/");
                            setcookie("loggedin", true, time() + 3600, "/");
                            header("Location: ../index.php");
                        }
                        
                    }else{
                        $usernameAvailable = false;
                    }
                    
                }else{
                    $emailExists = true;
                }

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
    <title>Create your account</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/theme.css">
</head>

<body class= <?php if($isDark) echo "'dark'"; else echo "'light'"; ?> >
    <main class='form-wrapper'>
        <form action='' method='post' class='login-signup'>
            <h2>Sign up</h2>
            <div class='inputs'>
                <input type='email' name='email' id='email' class='inp-light' placeholder='Email' required>
                <?php
                    if($emailExists){
                        echo "<p class='warning' style='color: red; font-weight: 600; text-align: left;'>Email already exists!</p>";
                    }
                ?>
                <input type='text' name='username' id='username' class='inp-light' placeholder='Username' required>
                <?php
                    if(!$usernameAvailable){
                        echo "<p class='warning' style='color: red; font-weight: 600; text-align: left;'>Username already Exists!</p>";
                    }
                ?>
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
            </div>
            <div class='options'>
                <p>Already have an account? <a class='an-light' href='./login.php'>Log in</a></p>
                <!-- <a class='an-light' href='./reset.html'>Reset Password</a> -->
            </div>
            <button class='btn-light submit-btns' type='submit'>Sign up</button>
        </form>
    </main>
</body>

</html>