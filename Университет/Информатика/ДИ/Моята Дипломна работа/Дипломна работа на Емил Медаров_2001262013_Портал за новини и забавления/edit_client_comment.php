<?php
session_start();
include_once "config.php";
include_once "db.php";

// Проверка дали потребителят е логнат и е админ
if (!isset($_SESSION['user']) || $_SESSION['user']['userType'] !== 'client') {
    echo "Нямате права да редактирате този коментар.";
    exit;
}

// Получаване на comment_id от URL параметри
$comment_id = isset($_GET['comment_id']) ? (int)$_GET['comment_id'] : 0;

if ($comment_id <= 0) {
    echo "Невалиден коментар.";
    exit;
}

// Получаване на текущото съдържание на коментара
$sql = "SELECT comment_content FROM comments WHERE comment_id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $comment_id, $_SESSION['user']['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Коментарът не съществува или нямате права да го редактирате.";
    exit;
}

$comment = $result->fetch_assoc();

// Обработка на формата за редактиране на коментар
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_comment_content = trim($_POST['comment_content']);

    if (!empty($new_comment_content)) {
        $update_sql = "UPDATE comments SET comment_content = ? WHERE comment_id = ? AND user_id = user_id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_comment_content, $comment_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo "Коментарът беше успешно редактиран.";
        } else {
            echo "Неуспешна редакция.";
        }

        $update_stmt->close();
    } else {
        echo "Коментарът не може да бъде празен.";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <title>Редактиране на коментар</title>
    <style>
         *{
    margin: 0;
    padding: 0;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
    user-select: none;
    -webkit-user-drag: none;
}
::selection{
    user-select: none;
}
/* Hide scrollbar for Chrome, Safari and Opera */
body::-webkit-scrollbar {
    display: none;
}
  
  /* Hide scrollbar for IE, Edge and Firefox */
body {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}
html{
    scroll-behavior: smooth;
}
body {
            background-color: #A1B5D8;
            min-height: 70vh;
            /* padding: 1rem; */
            box-sizing: border-box;
            display: flex;
            /* justify-content: center; */
            flex-direction: column;
            align-items: center;
            color: #fff;
            font-family:'Times New Roman', Times, serif;
            /* text-align: center;
            font-size: 130%; */
        }
        .form-container {
            width: 100%;
            height: auto;
            min-height: 450px;
            max-width: 600px;
            min-width: 250px;
            background: #738290;
            background-image: radial-gradient(#C2D8B9 7.2%, transparent 0);
            background-size: 25px 25px;
            border-radius: 20px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
            padding: 1rem;
            box-sizing: border-box;
            margin-top: 50px;
            text-align: center;
            font-size: 130%;
            position: absolute;
            top: 50px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 8px;
            color: black;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: black;
            text-align: center;
        }

        #form textarea{ 
            width: 100%;
            border: 0;
            outline: none;
            background: #FFFCF7;
            padding: 15px;
            margin: 15px 0;
            color: black;
            font-size: 14px;
            border-radius: 6px;
            
        }
        
        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: lightgreen;
        }
        .form-container .href {
        position: absolute;
        top: -50px;
        left: 32%;
        font-size: 16px;
        color: #F2F6D0; 
        text-decoration: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .form-container .href:hover {
        color: #fff;
    }
    </style>
</head>
<body>

<div class="form-container">
<a class="href" href="index.php">Назад към началната страница</a>
<h2>Редактиране на коментар</h2>
<form id="form" action="" method="post">
<label for="comment_content">Съдържание на коментара:</label><br>
<textarea id="comment_content" name="comment_content"><?php echo htmlspecialchars($comment['comment_content']); ?></textarea><br><br>
<button type="submit">Запази промените</button>
</form>
</div>

</body>
</html>
