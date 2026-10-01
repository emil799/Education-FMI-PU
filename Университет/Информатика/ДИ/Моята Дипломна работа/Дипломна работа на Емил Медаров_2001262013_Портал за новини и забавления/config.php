<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_Brief";

// Създаваме връзката
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяваме връзката
if ($conn->connect_error) {
    die("Връзката с базата данни не бе успешна: " . $conn->connect_error);
}
?>
