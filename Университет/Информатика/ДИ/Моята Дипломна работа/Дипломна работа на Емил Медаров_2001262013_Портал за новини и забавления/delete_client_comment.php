<?php
session_start();
include_once "config.php";
include_once "db.php";

// Проверка дали потребителят е администратор
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] !== 'client') {
    echo "Нямате права за изтриване на коментари.";
    exit;
}

// Получаване на comment_id от URL параметрите
$comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;

// Проверка дали comment_id е валиден
if ($comment_id <= 0) {
    echo "Невалиден коментар.";
    exit;
}

// Извлечете user_id на текущия потребител
$user_id = $_SESSION['user']['user_id'];

// Изтриване на коментара от базата данни
$sql = "DELETE FROM comments WHERE comment_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $comment_id, $user_id);

if ($stmt->execute()) {
    echo "Коментарът беше успешно изтрит.";
} else {
    echo "Грешка при изтриване на коментара.";
}

$stmt->close();
$conn->close();

// Пренасочване обратно към страницата със статията
$previous_page = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
header("Location: $previous_page");
exit;
?>