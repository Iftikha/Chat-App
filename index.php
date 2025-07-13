<!-- Yahabn pr saaray cntacts show hongay agar login 
session available hai warna phir hum log phlay log ya reguster krwaengay. -->

<?php
include "assets/config/connectDB.php";
if (!isset($_COOKIE['email']) && !isset($_COOKIE['name']) && !isset($_COOKIE['loggedin']))
    header('Location: ./auth/login.php');
$conn = connectDB();
$isDark = false;
if (isset($_COOKIE['isDark'])) {
    $isDark = $_COOKIE['isDark'];
} else {
    setcookie('isDark', $isDark, time() + 360000, '/');
}
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if ($isDark) {
        setcookie('isDark', "", time() - 360000, "/");
        $isDark = false;
        setcookie('isDark', $isDark, time() + 360000, "/");
    } else {
        setcookie('isDark', "", time() - 360000, "/");
        $isDark = true;
        setcookie('isDark', $isDark, time() + 360000, "/");
    }
    header("Location: index.php");
}

$sql = "SELECT * FROM `users`";
$result = $conn->query($sql);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App - Contacts</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/theme.css">
    <script src="assets/js/script.js"></script>
</head>

<body class=<?php if ($isDark) echo "'dark'" ; else echo "'light'" ; ?>>
    <header>
        <nav class="top">
            <div class="right">
                <h1>Chat App</h1>
            </div>
            <div class="left">
                <form method="post">
                    <button class="btn-light small-btns" type="submit"><img src=<?php if (!$isDark)
                            echo "'assets/images/icons/dark-theme.png'" ; else
                            echo "'assets/images/icons/light-theme.png'" ; ?> alt=""></button>
                </form>
                <button class="small-btns btn-light" id="more-options" onclick="toggleMenu()"><img
                        src="assets/images/icons/more-icon.png" alt=""></button>
                <div class="menu hidden" id="menu">
                    <a class="an-light menu-item"
                        href="profile.php?username=<?php echo $_COOKIE['name']; ?>">Profile</a>
                    <hr>
                    <a class="an-light menu-item" href="setting.php">Setting</a>
                    <hr>
                    <a class="an-light menu-item" href="logout.php">Log out</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="Contacts">
        <!-- This is the contact template that we'll be using to show the contacts after fetching them from the backend -->
        <div class="contact-item">

            <?php
            while ($row = $result->fetch_assoc()) {
                $username = $row['username'];
                if($username != $_COOKIE['name']){
                    $encodedUsername = urlencode($username);
                    echo "
                    <div class='contact'>
        <div class='leftContact'>
            <img src='./" . $row['pfp_path'] . "' alt=''>
        </div>
        <div class='rightContact'>
            <div class='contactName'>
            <h3><a href='chat.php?user={$encodedUsername}' class='contactName hover-here'>{$username}</a></h3>
            </div>
            <div class='msg-contact'>
            <p class='last-msg'>This is the last message.</p>
            <p class='time'>15:09</p>
            </div>
            </div>
            </div>
            <hr class='contact-divider'>";
            }
            }
            ?>
        </div>
        <!-- Contact template ends here -->


    </main>

</body>

</html>