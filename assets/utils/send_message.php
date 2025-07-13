<?php 
include '../config/connectDB.php';
$conn = connectDB();

if(isset($_POST['sender'], $_POST['reciever'], $_POST['text-msg'])){
    $sender = $_POST['sender'];
    $reciever = $_POST['reciever'];
    $message = trim($_POST['text-msg']);

    if(!empty($message)){
        $stmt = $conn->prepare("INSERT INTO messages (sender, reciever, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $sender, $reciever, $message);
        $stmt->execute();
        $stmt->close();
    }
}
?>
