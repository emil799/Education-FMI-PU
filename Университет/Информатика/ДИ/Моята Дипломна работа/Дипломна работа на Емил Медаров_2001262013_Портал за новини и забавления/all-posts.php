<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "daily_Brief";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Функция за генериране на връзка към страницата на статията
function generatePostLink($category_name, $post_key) {
    $category_pages = [
        'България' => 'bulgaria.php',
        'Бизнес' => 'business.php',
        'Забавления' => 'entertainment.php',
        'Спорт' => 'sport.php'
    ];
    return isset($category_pages[$category_name]) ? $category_pages[$category_name] . '?id=' . $post_key : '#';
}

// Получаване на текущата страница и определяне на офсета
$items_per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Вземете параметрите от URL
$filter_column = '';
$filter_value = '';

if ($category_name == 'България') {
    $filter_column = 'location_name';
    $filter_value = isset($_GET['location_name']) ? $_GET['location_name'] : '';
} elseif ($category_name == 'Бизнес') {
    $filter_column = 'business_type';
    $filter_value = isset($_GET['business_type']) ? $_GET['business_type'] : '';
} elseif ($category_name == 'Забавления') {
    $filter_column = 'entertainment_type';
    $filter_value = isset($_GET['entertainment_type']) ? $_GET['entertainment_type'] : '';
} elseif ($category_name == 'Спорт') {
    $filter_column = 'sport_type';
    $filter_value = isset($_GET['sport_type']) ? $_GET['sport_type'] : '';
}

// Създаване на заявка за избраната категория
$category_sql = "SELECT category_name FROM categories WHERE category_id = $category_id";
$category_result = $conn->query($category_sql);
$category_row = $category_result->fetch_assoc();
$category_name = $category_row['category_name'];

// Определяне на SQL заявката въз основа на категорията
$sql = "";
$post_key_column = ''; // Колоната за ключа на поста

switch ($category_name) {
    case 'България':
        $post_key_column = 'bulgaria_id';
        $sql = "SELECT bulgaria.*, bulgaria_id AS post_id, bulgaria_post_title AS post_title, bulgaria_post_description AS post_description, bulgaria_post_photo AS post_photo, date_published 
                FROM bulgaria
                WHERE category_id = $category_id";
        if ($filter_value) {
            $sql .= " AND $filter_column = '$filter_value'";
        }
        $sql .= " ORDER BY date_published DESC
                LIMIT $items_per_page OFFSET $offset";
        $count_sql = "SELECT COUNT(*) as total FROM bulgaria WHERE category_id = $category_id";
        if ($filter_value) {
            $count_sql .= " AND $filter_column = '$filter_value'";
        }
        break;

    case 'Бизнес':
        $post_key_column = 'business_id';
        $sql = "SELECT business.*, business_id AS post_id, business_post_title AS post_title, business_post_description AS post_description, business_post_photo AS post_photo, date_published 
                FROM business
                WHERE category_id = $category_id";
        if ($filter_value) {
            $sql .= " AND $filter_column = '$filter_value'";
        }
        $sql .= " ORDER BY date_published DESC
                LIMIT $items_per_page OFFSET $offset";
        $count_sql = "SELECT COUNT(*) as total FROM business WHERE category_id = $category_id";
        if ($filter_value) {
            $count_sql .= " AND $filter_column = '$filter_value'";
        }
        break;

    case 'Забавления':
        $post_key_column = 'entertainment_id';
        $sql = "SELECT entertainments.*, entertainment_id AS post_id, entertainment_post_title AS post_title, entertainment_post_description AS post_description, entertainment_post_photo AS post_photo, date_published 
                FROM entertainments
                WHERE category_id = $category_id";
        if ($filter_value) {
            $sql .= " AND $filter_column = '$filter_value'";
        }
        $sql .= " ORDER BY date_published DESC
                LIMIT $items_per_page OFFSET $offset";
        $count_sql = "SELECT COUNT(*) as total FROM entertainments WHERE category_id = $category_id";
        if ($filter_value) {
            $count_sql .= " AND $filter_column = '$filter_value'";
        }
        break;

    case 'Спорт':
        $post_key_column = 'sport_id';
        $sql = "SELECT sport.*, sport_id AS post_id, sport_post_title AS post_title, sport_post_description AS post_description, sport_post_photo AS post_photo, date_published 
                FROM sport
                WHERE category_id = $category_id";
        if ($filter_value) {
            $sql .= " AND $filter_column = '$filter_value'";
        }
        $sql .= " ORDER BY date_published DESC
                LIMIT $items_per_page OFFSET $offset";
        $count_sql = "SELECT COUNT(*) as total FROM sport WHERE category_id = $category_id";
        if ($filter_value) {
            $count_sql .= " AND $filter_column = '$filter_value'";
        }
        break;
}

$result = $conn->query($sql);
$count_result = $conn->query($count_sql);
$count_row = $count_result->fetch_assoc();
$total_items = $count_row['total'];
$total_pages = ceil($total_items / $items_per_page);

$allPostsHTML = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allPostsHTML .= "<div class='post-item'>";
        $allPostsHTML .= "<img src='data:image;base64," . base64_encode($row['post_photo']) . "' alt='Post Image'>";
        $postLink = generatePostLink($category_name, $row[$post_key_column]);
        $allPostsHTML .= "<h3><a href='{$postLink}'>{$row['post_title']}</a></h3>";
        $contentPreview = mb_substr($row['post_description'], 0, 50, 'UTF-8');
        $allPostsHTML .= "<p>{$contentPreview}...</p>";
        $allPostsHTML .= "<span>{$row['date_published']}</span>";
        $allPostsHTML .= "<a href='full-all-posts.php?category={$category_name}&post_id={$row['post_id']}'>Виж повече</a>";
        $allPostsHTML .= "</div>";
    }
} else {
    $allPostsHTML = "Няма налични статии.";
}

// Генериране на навигацията за страниците
$paginationHTML = "";
if ($total_pages > 1) {
    $paginationHTML .= "<nav class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        $activeClass = $i === $page ? "class='active'" : "";
        $paginationHTML .= "<a href='?page=$i' $activeClass>$i</a>";
    }
    $paginationHTML .= "</nav>";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Други категории статии</title>
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body>
<style>
    nav{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;
        background-color: #333;
    }
    nav ul{
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    nav ul li{
        /* display: inline-block; */
        /* list-style: none; */
        position: relative;
        margin: 10px 20px;
    }
    nav ul li a{
        color: #F2F6D0;
        text-decoration: none;
        font-size: 14px;
        position: relative;
    }
    nav ul li a::after{
        content: '';
        width: 0;
        height: 3px;
        background: #0095ff;
        position: absolute;
        left: 0;
        bottom: -6px;
        transition: 0.5s;
    }
    nav ul li a:hover::after{
        width: 100%;
    }

    .sub-nav {
            display: none;
            position: absolute;
            background-color: #333;
            padding: 10px;
            /* border-radius: 5px; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1;
            min-width: 125px;
            white-space: nowrap;
            margin-top: 7px;
        }

    .sub-nav li {
    margin: 17px 0;
    display: block;
    }

    nav ul li:hover .sub-nav {
    display: block;
    }
    .container {
    position: relative;
    box-sizing: border-box;
    width: fit-content;
    }

    .mainbox {
    box-sizing: border-box;
    position: relative;
    width: 230px;
    height: 30px;
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: center;
    border-radius: 160px;
    background-color: rgb(0, 0, 0);
    transition: all 0.3s ease;
    }

    .checkbox:focus {
    border: none;
    outline: none;
    }

    .checkbox:checked {
    right: 10px;
    }

    .checkbox:checked ~ .mainbox {
    width: 50px;
    }

    .checkbox:checked ~ .mainbox .search_input {
    width: 0;
    height: 0px;
    }

    .checkbox:checked ~ .mainbox .iconContainer {
    padding-right: 8px;
    }

    .checkbox {
    box-sizing: border-box;
    width: 30px;
    height: 30px;
    position: absolute;
    right: 17px;
    top: 10px;
    z-index: 9;
    cursor: pointer;
    appearance: none;
    }

    .search_input {
    box-sizing: border-box;
    height: 100%;
    width: 170px;
    background-color: transparent;
    border: none;
    outline: none;
    padding-bottom: 4px;
    padding-left: 10px;
    font-size: 1em;
    color: white;
    transition: all 0.3s ease;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }

    .search_input::placeholder {
    color: rgba(255, 255, 255, 0.776);
    }

    .iconContainer {
    box-sizing: border-box;
    padding-top: 5px;
    width: fit-content;
    transition: all 0.3s ease;
    }

    .search_icon {
    box-sizing: border-box;
    fill: white;
    font-size: 1.3em;
    }
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
header {
    color: #fff;
    /* padding: 5px; */
    text-align: center;
    width: 100%;
    height: 100vh;
    /* padding: 10px 0; */
}
.logo{
    width: 140px;
    margin-right: 35px;
}

footer {
    background-color: transparent;
    color: #0095ff;
    text-align: center;
    padding: 10px;
    width: 100%;
    position: absolute;
    top: 1000px;
}
footer p{
    font-size: 25px;
    font-weight: 700;
    margin-top: 20px;
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

        .pagination {
            position: absolute;
            top: 700px;
            right: 42.5%;
            background-color: #4C5760;
            padding: 10px;
            text-align: center;
        }

        .pagination a {
            color: #F2F6D0;
            padding: 5px 10px;
            margin: 2px;
            text-decoration: none;
            border: 1px solid #F2F6D0;
        }

        .pagination a.active {
            background-color: lightblue;
            color: white;
            border: 1px solid #F2F6D0;
            border-radius: 5px;
        }
</style>
<header>
<nav>
        <img src="images/logo.png" class="logo">
            <ul>
                <li><a href="index.php">Начало</a></li>
                <li><a href="bulgaria.php">България</a>
                <i class="fa-solid fa-chevron-down"></i>
                <ul class="sub-nav">
                    <li><a href="bulgaria.php?location_name=София">София</a></li>
                    <li><a href="bulgaria.php?location_name=Пловдив">Пловдив</a></li>
                    <li><a href="bulgaria.php?location_name=Варна">Варна</a></li>
                    <li><a href="bulgaria.php?location_name=Бургас">Бургас</a></li>
                    <li><a href="bulgaria.php?location_name=Стара Загора">Стара Загора</a></li>
                    <li><a href="bulgaria.php?location_name=Плевен">Плевен</a></li>
                    <li><a href="bulgaria.php?location_name=Русе">Русе</a></li>
                    <li><a href="bulgaria.php?location_name=Велико Търново">Велико Търново</a></li>
                    <li><a href="bulgaria.php?location_name=Хасково">Хасково</a></li>
                    <li><a href="bulgaria.php?location_name=Кърджали">Кърджали</a></li>
                </ul>
                </li>
                <li><a href="business.php">Бизнес</a>
                <i class="fa-solid fa-chevron-down"></i>
                <ul class="sub-nav">
                    <li><a href="business.php?business_type=Технологии">Технологии</a></li>
                    <li><a href="business.php?business_type=Автомобили">Автомобили</a></li>
                </ul>
            </li>
                <li><a href="entertainment.php">Забавления</a>
                <i class="fa-solid fa-chevron-down"></i>
                <ul class="sub-nav">
                    <li><a href="entertainment.php?entertainment_type=Вицове">Вицове</a></li>
                    <li><a href="entertainment.php?entertainment_type=Хороскопи">Хороскопи</a></li>
                    <li><a href="entertainment.php?entertainment_type=Филми">Филми</a></li>
                    <li><a href="entertainment.php?entertainment_type=Пътувания">Пътувания</a></li>
                    <li><a href="entertainment.php?entertainment_type=Култура">Култура</a></li>
                    <li><a href="entertainment.php?entertainment_type=Любопитно">Любопитно</a></li>
                </ul>
            </li>
                <li><a href="sport.php">Спорт</a>
                <i class="fa-solid fa-chevron-down"></i>
                <ul class="sub-nav">
                    <li><a href="sport.php?sport_type=БГ Футбол">БГ Футбол</a></li>
                    <li><a href="sport.php?sport_type=Баскетбол">Баскетбол</a></li>
                    <li><a href="sport.php?sport_type=Волейбол">Волейбол</a></li>
                    <li><a href="sport.php?sport_type=Тенис">Тенис</a></li>
                </ul>
            </li>
                <li><a href="index.html">Игри</a></li>
                <?php if (isset($_SESSION['user']['username'])): ?>
                    <li><a href="login.php">Здравей, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></a></li>
                    <li><a href="logout.php">Излез</a></li>
                <?php else: ?>
                    <li><a href="login.php">Моят профил</a></li>
                <?php endif; ?>
                <li><a href="register.php">Регистрация</a></li>
                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['userType'] === 'client' || $_SESSION['user']['userType'] === 'admin')): ?>
                    <li><a href="add-post.php">Статия</a>
                        <i class="fa-solid fa-chevron-down"></i>
                        <ul class="sub-nav">
                        <?php if ($_SESSION['user']['userType'] == 'admin'): ?>
                                <li><a href="delete-admin-post.php">Изтрий статия от всички</a></li>
                                <li><a href="edit-admin-post.php">Редактирай статия от всички</a></li>
                            <?php elseif ($_SESSION['user']['userType'] == 'client'): ?>
                                <li><a href="delete-client-post.php">Изтрий статия от моите</a></li>
                                <li><a href="edit-client-post.php">Редактирай статия от моите</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                <?php endif; ?>
                <li><form action="search-bar.php" method="GET" id="search-form">
                        <div class="container">
                <input checked="" class="checkbox" type="checkbox"> 
                <div class="mainbox">
                    <div class="iconContainer">
                        <svg viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg" class="search_icon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                    </div>
                <input class="search_input" placeholder="Search..." type="text">
                </div>
            </div>
        </form></li>
            </ul>
        </nav>
</header>
<section id="all-categories">
    <div class="all-container">
    <?php echo $allPostsHTML; ?>
    <?php echo $paginationHTML; ?>
    </div>
</section>
<footer>
    <p>&copy; 2024 Daily Brief</p>
</footer>

<script>
        document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById('search-form');

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the default way

        const searchInput = document.querySelector('.search_input');
        const searchTerm = searchInput.value.trim();

        if (searchTerm !== '') {
            window.location.href = `search-bar.php?search=${encodeURIComponent(searchTerm)}`;
        }
    });
});


    </script>
</body>
</html>
