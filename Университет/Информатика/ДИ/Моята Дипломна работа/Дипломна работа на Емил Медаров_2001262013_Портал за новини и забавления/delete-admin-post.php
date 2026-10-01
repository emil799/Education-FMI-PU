<?php
session_start();
include_once "config.php";
include_once "db.php";
if (isset($_SESSION['user']) && $_SESSION['user']['userType'] === 'admin') {
// Проверка дали формата е изпратена
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка за избрани постове за изтриване
    if (isset($_POST["delete_posts"]) && isset($_POST["category"])) {
        $category = $_POST["category"];
        $postsToDelete = $_POST["delete_posts"];
        $postsIds = implode(",", array_map('intval', $postsToDelete)); // Обработване на IDs
        $idColumn = '';

        // Определяне на таблицата и колоната за ключа на поста въз основа на категорията
        switch ($category) {
            case 'България':
                $table = 'bulgaria';
                $idColumn = 'bulgaria_id';
                break;
            case 'Бизнес':
                $table = 'business';
                $idColumn = 'business_id';
                break;
            case 'Забавления':
                $table = 'entertainments';
                $idColumn = 'entertainment_id';
                break;
            case 'Спорт':
                $table = 'sport';
                $idColumn = 'sport_id';
                break;
            default:
                echo "Невалидна категория.";
                exit;
        }

        // Изпълнение на SQL заявката
        $sql = "DELETE FROM $table WHERE $idColumn IN ($postsIds)";
        if ($conn->query($sql) === TRUE) {
            echo "Избраните постове бяха успешно изтрити!";
        } else {
            echo "Грешка при изтриване на постовете: " . $conn->error;
        }
    } else {
        echo "Моля, изберете постове и категория за изтриване.";
    }
}

// Извличане на категориите
$categorySQL = "SELECT category_id, category_name FROM categories";
$categoriesResult = $conn->query($categorySQL);

// Извличане на постовете въз основа на избраната категория
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 6;
$offset = ($page - 1) * $items_per_page;
$postsHTML = "";
$paginationHTML = "";
if ($selectedCategory) {
    $table = '';
    $idColumn = '';
    $titleColumn = '';
    $descriptionColumn = '';
    $photoColumn = '';
    
    switch ($selectedCategory) {
        case 'България':
            $table = 'bulgaria';
            $idColumn = 'bulgaria_id';
            $titleColumn = 'bulgaria_post_title';
            $descriptionColumn = 'bulgaria_post_description';
            $photoColumn = 'bulgaria_post_photo';
            break;
            case 'Бизнес':
                $table = 'business';
                $idColumn = 'business_id';
                $titleColumn = 'business_post_title';
                $descriptionColumn = 'business_post_description';
                $photoColumn = 'business_post_photo';
                break;
                case 'Забавления':
                    $table = 'entertainments';
                    $idColumn = 'entertainment_id';
                    $titleColumn = 'entertainment_post_title';
                    $descriptionColumn = 'entertainment_post_description';
                    $photoColumn = 'entertainment_post_photo';
                    break;
                    case 'Спорт':
                        $table = 'sport';
                        $idColumn = 'sport_id';
                        $titleColumn = 'sport_post_title';
                        $descriptionColumn = 'sport_post_description';
                        $photoColumn = 'sport_post_photo';
                        break;
                        default:
                        $postsHTML = "Невалидна категория.";
                        break;
                    }
                    
                    if ($table) {
                        $sql = "SELECT $idColumn, $titleColumn, $descriptionColumn, $photoColumn, date_published FROM $table ORDER BY date_published DESC 
        LIMIT $items_per_page OFFSET $offset";
        $result = $conn->query($sql);
        
        // Извличане на общия брой постове за навигация
        $count_sql = "SELECT COUNT(*) as total FROM $table";
        $count_result = $conn->query($count_sql);
        $count_row = $count_result->fetch_assoc();
        $total_items = $count_row['total'];
        $total_pages = ceil($total_items / $items_per_page);
        
        
        
        if ($result->num_rows > 0) {
            $postsHTML .= "<form class='delete-post' action='delete-admin-post.php' method='post'>";
            $postsHTML .= "<input type='hidden' name='category' value='$selectedCategory'>";
            while ($row = $result->fetch_assoc()) {
                $postId = $row[$idColumn];
                $postTitle = $row[$titleColumn];
                $postContent = $row[$descriptionColumn];
                $postDate = $row['date_published'];
                $postPhoto = $row[$photoColumn];

                $postsHTML .= "<div class='post-item'>";
                $postsHTML .= "<div class='checkbox-container'>";
                $postsHTML .= "<input type='checkbox' name='delete_posts[]' value='$postId'>";
                $postsHTML .= "</div>";

                // Проверка дали има изображение и добавяне на HTML
                if (!empty($postPhoto)) {
                    $postsHTML .= "<img src='data:image;base64," . base64_encode($postPhoto) . "' alt='Post Image'>";
                }
                
                $postsHTML .= "<h3>$postTitle</h3>";
                $contentPreview = mb_substr($postContent, 0, 50, 'UTF-8');
                $postsHTML .= "<p>$contentPreview...</p>";
                $postsHTML .= "<span>$postDate</span>";
                $postsHTML .= "<a href='full-all-posts.php?category=$selectedCategory&post_id=$postId'>Виж повече</a>";
                $postsHTML .= "</div>";
            }
            // Генериране на навигацията за страниците
            
            if ($total_pages > 1) {
                $paginationHTML .= "<nav class='pagination'>";
                for ($i = 1; $i <= $total_pages; $i++) {
                    $activeClass = $i === $page ? "class='active'" : "";
                    $paginationHTML .= "<a href='?category=$selectedCategory&page=$i' $activeClass>$i</a>";
                }
                $paginationHTML .= "</nav>";
            }

            $postsHTML .= "<button type='submit'>Изтрий избраните постове</button>";
            $postsHTML .= "</form>";
        } else {
            $postsHTML = "Няма добавени постове в избраната категория.";
        }
    }
}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <title>Изтриване на постове</title>
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
    top: 1200px;
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

        .form-container {
            width: 100%;
            height: auto;
            min-height: 150px;
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

        .form-container select {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            position: absolute;
            top: 750px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: lightgreen;
        }

    h2 {
        text-align: center;
    }
.message-container p{
        font-size: 25px;
        font-weight: 500;
        color: darkred;
    }
    .delete-post{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
}
    #all-categories {
    position: absolute;
    top: 300px;
    left: 260px;
    justify-content: center;
    
}

.all-container {
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    max-width: 1000px;
}
.checkbox-container {
    position: absolute;
    top: 5px;
    left: 5px;
}
.post-item {
    position: relative;
    flex-basis: calc(33.333% - 20px);
    flex-grow: 0;
    background-color: #4C5760;
    border-radius: 10px;
    border: 1px solid #232323;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 10px;
    margin-left: 0;
    padding: 15px;
    width: 300px; 
    height: 320px; 
    /* overflow: hidden; */
    cursor: pointer;
    transition: transform 0.3s ease-in-out;
    /* box-sizing: border-box; */
}

.post-item img {
    max-width: 275px;
    max-height: 250px;
    border-radius: 10px;
}

.post-item a {
    display: block;
    text-decoration: none;
    color: inherit;
}

.post-item:hover {
    transform: scale(1.05); /* При увеличаване на мишката, увеличете размера на новината */
}

/* Стил за заглавието на новината */
.post-item h3 {
    margin-top: 0;
    font-size: 16px;
    text-align: center;
}

/* Стил за текста на новината в списъка */
.post-item p {
    font-size: 14px;
    line-height: 1.4;
}

.post-item span {
    display: block;
    color: #a9a9a9;
    font-size: 12px;
    margin-top: 10px;
}
.pagination {
            position: absolute;
            top: 680px;
            right: 46.5%;
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
</head>
<body>
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

    
    <div class="form-container">
        <h2>Изтриване на постове</h2>
        <form action="delete-admin-post.php" method="get">
            <label for="category">Изберете категория:</label>
            <select id="category" name="category" onchange="this.form.submit()">
                <option value="">Изберете категория</option>
                <?php
                if ($categoriesResult->num_rows > 0) {
                    while ($row = $categoriesResult->fetch_assoc()) {
                        $categoryName = $row['category_name'];
                        $selected = ($categoryName === $selectedCategory) ? 'selected' : '';
                        echo "<option value='$categoryName' $selected>$categoryName</option>";
                    }
                }
                ?>
            </select>
        </form>
    </div>
    <section id="all-categories">
        <div class="all-container">
            <?php echo $postsHTML; ?>
            <?php echo $paginationHTML; ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 Daily Brief</p>
    </footer>
</body>
</html>