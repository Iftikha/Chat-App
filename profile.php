<?php
include "assets/config/connectDB.php";
$conn = connectDB();
$isDark = false;
if (isset($_COOKIE['isDark'])) {
    $isDark = $_COOKIE['isDark'];
}
$userExists = false;

if (isset($_COOKIE['email']) && isset($_COOKIE['name']) && isset($_COOKIE['loggedin'])) {
    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $email = $_COOKIE['email'];
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);
        if($result -> num_rows == 0){
            $imagePath = "assets/images/pfp/defaul-user.png"; 
        }else{
            $row = $result -> fetch_assoc();
            $imagePath = $row["pfp_path"];
        }
        if (isset($_POST['upload']) && isset($_FILES['pfpUploaded'])) {
            $file = $_FILES['pfpUploaded'];

            $date = date("Y-m-d_H-i-s"); // format for file name

            $filename = $file['name'];
            $tmpname = $file['tmp_name'];
            $filesize = $file['size'];
            $fileerror = $file['error'];

            $fileext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($fileext, $allowed)) {
                if ($fileerror === 0) {
                    if ($filesize < 5 * 1024 * 1024) { // 5MB max
                        $newname = $username . "-" . $date . "." . $fileext;
                        $destination = "assets/images/uploads/pfp/" . $newname;

                        if (move_uploaded_file($tmpname, $destination)) {
                            $sql = "UPDATE users SET pfp_path = '$destination' WHERE users.email = '$email';";
                            $conn->query($sql);

                            // echo "File uploaded successfully as $newname";
                            // save to DB or session here if needed
                        } else {
                            echo "Error moving file.";
                        }
                    } else {
                        echo "File too large.";
                    }
                } else {
                    echo "Upload error: $fileerror";
                }
            } else {
                echo "Invalid file type.";
            }
        }
        if(isset($_POST['update'])){
            $c_username = $_POST['c_username'];
            echo $c_username;
            if($c_username === $username){
                header('Location: profile.php');
            }else{
                $sql = "SELECT * FROM users WHERE username = '$c_username'";
                $result = $conn->query($sql);
                if($result->num_rows == 0){
                    $sql = "UPDATE users SET username = '$c_username' WHERE users.username = '$username'";
                    if($conn -> query($sql)){
                    $username = $c_username;
                    setcookie('name', '', time() - 3600, '/');
                    setcookie('name', $c_username, time() + 3600, '/');
                    }
                }else{
                    $userExists = true;
                }
            }
        }




    } else {
        header('Location: ./auth/login.php');
    }
} else {
    header('Location: ./auth/login.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - <?= $username ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <script src="assets/js/script.js"></script>
</head>

<body class="<?php if ($isDark)
    echo 'dark';
else
    echo 'light'; ?>">
    <section class="heading-profile">
        <h1>User Profile</h1>
    </section>
    <main class="profile">
        <div class="pfp-my">
            <button class="small-btns btn-light edit-btn" onclick='modalToggle()'><img
                    src="assets/images/icons/edit-icon.png" alt=""></button>
            <img src="./<?= $imagePath; ?>" alt="" class="pfp-image">
        </div>
        <div class="info">
            <p class="info-name"><?= $username ?><a onclick="toggleModal('<?= $username; ?>')" class="edit-btn-user"><img src="assets/images/icons/edit-icon.png" alt=""></a></p>
            <p class="info-email"><?= $email ?></p>
            <a href="./assets/utils/reset.php"><button class="btn-light submit-btns reset-cta-btn">Reset Password</button></a>
            <a href="index.php"><button class="btn-light submit-btns reset-cta-btn">Cancel</button></a>
        </div>
    </main>
    <section class="changePfpForm hidden" id="changePfpForm">
        <div class="header">
            <h2>Change Profile Photo</h2>
        </div>
        <div class="form">
            <form actiono="profile.php" method="POST" enctype="multipart/form-data">
                <label for="pfpUploaded" class="file-btn"><img src="assets/images/icons/camera-icon.png" alt=""></label>
                <input type="file" name="pfpUploaded" id="pfpUploaded" class="fileSelector">
                <div class="buttons">
                    <button class="btn-light submit-btns" name="upload">Continue</button><button
                        class="btn-light submit-btns" onclick='modalToggle()'>Cancel</button>
                </div>
            </form>
        </div>
    </section>

    <section class="changePfpForm hidden" id="changeUsernameForm">
        <div class="header">
            <h2>Change Username</h2>
        </div>
        <div class="form">
            <form actiono="" method="POST" enctype="multipart/form-data">
                <input type="text" class="inp-light" name="c_username" id="c_username" placeholder="New username">
                <?php
                    if($userExists){
                        echo "<p class='warning'>Username not available.</p>";
                    }
                ?>
                <div class="buttons">
                    <button class="btn-light submit-btns" name="update">Continue</button><button
                        class="btn-light submit-btns" onclick='toggleModal()'>Cancel</button>
                </div>
            </form>
        </div>
    </section>

</body>

</html>