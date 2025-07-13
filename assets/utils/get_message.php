<?php 
include '../config/connectDB.php';
$conn = connectDB();

$sender = $_POST['sender'] ?? '';
$reciever = $_POST['reciever'] ?? '';

if(!empty($sender) && !empty($reciever)){
    $stmt = $conn->prepare("SELECT * FROM messages 
        WHERE (sender=? AND reciever=?) OR (sender=? AND reciever=?) 
        ORDER BY id ASC");

    $stmt->bind_param("ssss", $sender, $reciever, $reciever, $sender);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        $msgClass = ($row['sender'] === $sender) ? "sent" : "rec";
        echo "<div class='msg $msgClass'>{$row['message']}</div>";
    }
    $stmt->close();
}
?>
