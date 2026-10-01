<?php
session_start();
include_once "config.php";
include_once "db.php";

echo '
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
';

// Получаване на post_id и категория от URL параметри
$post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Проверка дали потребителят е логнат
$is_logged_in = isset($_SESSION['user']['user_id']);
$user_id = $is_logged_in ? $_SESSION['user']['user_id'] : null;

// Извличане на потребителските данни ако потребителят е логнат
$user = null;
if ($is_logged_in) {
    $user_query = "SELECT username, user_email FROM users WHERE user_id = $user_id";
    $user_result = $conn->query($user_query);
    $user = $user_result->fetch_assoc();
}

// Обработка на формата за коментари
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $is_logged_in) {
    $comment_content = trim($_POST['comment_content']);
    if (!empty($comment_content)) {
    $comment_author_name = $user['username'];
    $comment_author_email = $user['user_email'];
    
    // Определяне на колоната и стойността за коментар
$comment_columns = [
    'bulgaria_id' => null,
    'business_id' => null,
    'entertainment_id' => null,
    'sport_id' => null
];

if ($category === 'България') {
    $comment_columns['bulgaria_id'] = $post_id;
} elseif ($category === 'Бизнес') {
    $comment_columns['business_id'] = $post_id;
} elseif ($category === 'Забавления') {
    $comment_columns['entertainment_id'] = $post_id;
} elseif ($category === 'Спорт') {
    $comment_columns['sport_id'] = $post_id;
}

// Подготвяне на SQL за добавяне на коментар
$stmt = $conn->prepare("INSERT INTO comments (comment_author_name, comment_author_email, comment_content, user_id, bulgaria_id, business_id, entertainment_id, sport_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssiiiii", $comment_author_name, $comment_author_email, $comment_content, $user_id, $comment_columns['bulgaria_id'], $comment_columns['business_id'], $comment_columns['entertainment_id'], $comment_columns['sport_id']);
$stmt->execute();
$stmt->close();
}else {
    echo "<p>Коментарът не може да бъде празен.</p>";
}
}

// Създаване на SQL заявка за извличане на пълната статия
switch ($category) {
    case 'България':
        $sql = "SELECT bulgaria_id AS post_id, bulgaria_post_title AS post_title, bulgaria_post_description AS post_description, bulgaria_post_photo AS post_photo, date_published FROM bulgaria JOIN categories ON bulgaria.category_id = categories.category_id WHERE bulgaria.bulgaria_id = ?";
        break;
    case 'Бизнес':
        $sql = "SELECT business_id AS post_id, business_post_title AS post_title, business_post_description AS post_description, business_post_photo AS post_photo, date_published FROM business JOIN categories ON business.category_id = categories.category_id WHERE business.business_id = ?";
        break;
    case 'Забавления':
        $sql = "SELECT entertainment_id AS post_id, entertainment_post_title AS post_title, entertainment_post_description AS post_description, entertainment_post_photo AS post_photo, date_published FROM entertainments JOIN categories ON entertainments.category_id = categories.category_id WHERE entertainments.entertainment_id = ?";
        break;
    case 'Спорт':
        $sql = "SELECT sport_id AS post_id, sport_post_title AS post_title, sport_post_description AS post_description, sport_post_photo AS post_photo, date_published FROM sport JOIN categories ON sport.category_id = categories.category_id WHERE sport.sport_id =?";
        break;
    default:
        $sql = "SELECT bulgaria_id AS post_id, bulgaria_post_title AS post_title, bulgaria_post_description AS post_description, bulgaria_post_photo AS post_photo, date_published FROM bulgaria JOIN categories ON bulgaria.category_id = categories.category_id WHERE bulgaria.bulgaria_id = ?"; // Дефолтна стойност в случай на невалидна категория
        break;
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();

$allHTML = "";

echo '<style> 
*{
    margin: 0;
    padding: 0;
    font-family: Poppins, sans-serif;
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
body{
    background-color: #5d5d5d;
    color: #1d1d1d;
    line-height: 1.5;
}

/* Стил за пълната новина */
.full-posts {
    max-width: 800px; /* Максимална ширина на пълната новина */
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
}

.full-posts h1 {
    font-size: 24px;
    text-align: center;
    color: #555;
    margin: 20px 0 10px;
}
.full-posts img{
    margin: 0 auto;
    max-width: 100%;
    max-height: 100%;
    border-radius: 10px;
    display: block;
    margin-bottom: 20px;
}
.full-posts p {
    text-align: left;
    margin-bottom: 20px;
    color: #777;
    font-size: 16px;
    line-height: 1.6;
}
.full-posts span{
    display: block;
    color: #888;
    font-size: 14px;
    margin-top: 10px;
}
.comment {
    position: relative;
    border: 1px solid #ddd;
    padding: 15px;
    margin-bottom: 25px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
.comment p {
    margin: 0;
    padding: 5px;
    margin-bottom: 5px;
}
.comment strong {
    display: block;
    color: #333;
    margin-bottom: 5px;
}
.comment .comment-date {
    font-size: 12px;
    color: #999;
    margin-bottom: 10px;
}
.comment .comment-content {
    color: #555;
    font-size: 14px;
}

/* Подреждане на бутоните в коментарния контейнер */
.comment .comment-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px; /* Разстояние между бутоните */
    margin-top: 0;
}

/* Стил за бутоните */
.comment button {
    padding: 8px 12px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 12px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.comment button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
}

.comment button:active {
    background-color: #003d80;
}

p{
text-align: center;
}
.form-container {
            width: 100%;
            height: auto;
            min-height: 450px;
            max-width: 600px;
            min-width: 250px;
            border-radius: 20px;
            padding: 1rem;
            box-sizing: border-box;
            margin: 50px auto;
            text-align: center;
            font-size: 130%;
            align-items: center;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: black;
            text-align: center;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 8px;
            color: black;
        }


        #form input, #form textarea{ 
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

    h2 {
        text-align: center;
    }

    #form select {
        width: 100%;
        padding: 10px;
        margin: 5px 0 20px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
</style>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allHTML .= "<div class='full-posts'>";
        $allHTML .= "<img src='data:image;base64," . base64_encode($row['post_photo']) . "' alt='Post Image'>";
        $allHTML .= "<h1>{$row['post_title']}</h1>";
        $allHTML .= "<p>{$row['post_description']}</p>";
        $allHTML .= "<span>{$row['date_published']}</span>";
        $allHTML .= "</div>";
    }
} else {
        $allHTML = "Няма налични статии.";
    }
    echo $allHTML;
    

// Форма за добавяне на коментар
if ($is_logged_in) {
echo '
<div class="form-container">
<h2>Добави коментар</h2>
<form id="form" action="" method="post">
    <label for="comment_content">Коментар:</label><br>
    <textarea id="comment_content" name="comment_content"></textarea><br>
    <button type="submit">Добави коментар</button>
</form>
</div>';
} else {
    echo '<p>Трябва да сте логнат, за да добавите коментар. <a href="login.php">Вход</a></p>';
}
// Определяне на колоната за постове в зависимост от категорията
$comment_column = '';
switch ($category) {
    case 'България':
        $comment_column = 'bulgaria_id';
        break;
    case 'Бизнес':
        $comment_column = 'business_id';
        break;
    case 'Забавления':
        $comment_column = 'entertainment_id';
        break;
    case 'Спорт':
        $comment_column = 'sport_id';
        break;
    default:
        $comment_column = 'bulgaria_id'; // Дефолтна стойност в случай на невалидна категория
        break;
}
// Проверете дали колоната е определена правилно
if (!$comment_column) {
    echo "Невалидна категория.";
    exit;
}

// Показване на коментарите
echo "<h2>Коментари</h2>";
$sql_comments = "SELECT comments.*, users.username, users.user_email 
                 FROM comments 
                 JOIN users ON comments.user_id = users.user_id 
                 WHERE comments.$comment_column = ?
                 ORDER BY comment_date_gmt ASC";

$stmt_comments = $conn->prepare($sql_comments);
$stmt_comments->bind_param("i", $post_id);
$stmt_comments->execute();
$result_comments = $stmt_comments->get_result();


if ($result_comments->num_rows > 0) {
    while ($comment = $result_comments->fetch_assoc()) {
        echo "<div class='comment'>";
        echo "<p><strong>{$comment['username']}</strong> <span class='comment-date'>({$comment['comment_date_gmt']}):</span></p>";
        echo "<p class='comment-content'>{$comment['comment_content']}</p>";

        // Проверка дали потребителят е логнат и дали е admin или client
        if ($is_logged_in) {
            echo "<div class='comment-actions'>";
            
            if ($_SESSION['user']['userType'] === 'admin') {
                echo "<button onclick=\"deleteCommentAdmin('{$comment['comment_id']}')\">Изтрий коментар от всички</button>";
                if ($comment['user_id'] == $user_id) {
                    echo "<button onclick=\"editCommentAdmin('{$comment['comment_id']}', '{$post_id}', '{$category}')\">Редактирай коментар от моите</button>";
                }
            } elseif ($_SESSION['user']['userType'] === 'client' && $comment['user_id'] == $user_id) {
                echo "<button onclick=\"deleteCommentClient('{$comment['comment_id']}')\">Изтрий коментар от моите</button>";
                echo "<button onclick=\"editCommentClient('{$comment['comment_id']}', '{$post_id}', '{$category}')\">Редактирай коментар от моите</button>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
} else {
    echo "<p>Няма коментари.</p>";
}
$stmt_comments->close();
$conn->close();
?>

<script>
function validateComment() {
    var commentContent = document.getElementById('comment_content').value.trim();
    if (commentContent === '') {
        alert('Коментарът не може да бъде празен.');
        return false;
    }
    return true;
}

function deleteCommentAdmin(commentId, userType) {
    if (confirm('Сигурни ли сте, че искате да изтриете този коментар?')) {
        window.location.href = `delete_admin_comment.php?comment_id=${commentId}&user_type=${userType}`;
    }
}

function editCommentAdmin(commentId, userType, postId, category) {
    window.location.href = `edit_admin_comment.php?comment_id=${commentId}&category=${encodeURIComponent(category)}&post_id=${postId}`;
}

function deleteCommentClient(commentId, userType) {
    if (confirm('Сигурни ли сте, че искате да изтриете този коментар?')) {
        window.location.href = `delete_client_comment.php?comment_id=${commentId}&user_type=${userType}`;
    }
}

function editCommentClient(commentId, userType, postId, category) {
    window.location.href = `edit_client_comment.php?comment_id=${commentId}&category=${encodeURIComponent(category)}&post_id=${postId}`;
}


</script>