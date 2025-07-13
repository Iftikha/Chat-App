<?php
    include './assets/config/connectDB.php';
    $isDark = false;
    if(isset($_COOKIE['isDark'])){
        $isDark = $_COOKIE['isDark'];
    }
    $isLoggedin = false;
        $conn = connectDB();
        // echo("Worked");
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->query($sql);

            if($result -> num_rows > 0){
                $row = $result-> fetch_assoc();
                    if(password_verify($password, $row['password'])){
                        setcookie( "email", $email, time() + 3600, "/");
                        setcookie( "name", $row['username'], time() + 3600, "/" );
                        setcookie("loggedin", true, time() + 3600, "/");
                        header("Location: ../index.php");

                    }
            }
        }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in to your account</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/theme.css">
</head>

<body class= <?php if($isDark) echo "'dark'"; else echo "'light'"; ?> >
    <main class='form-wrapper'>
        <form action='' method='post' class='login-signup'>
            <h2>Log in</h2>
            <div class='inputs'>
                <input type='email' name='email' id='email' class='inp-light' placeholder='Email' required>
                <input type='password' name='password' id='password' class='inp-light' placeholder='Password' required>
            </div>
            <div class='options'>
                <p>Don't have an account? <a class='an-light' href='..assets/utils/register.php'>Sign up</a></p>
                <a class='an-light' href='./reset.html'>Reset Password</a>
            </div>
            <button class='btn-light submit-btns' type='submit'>Log in</button>
        </form>
    </main>
</body>

</html>