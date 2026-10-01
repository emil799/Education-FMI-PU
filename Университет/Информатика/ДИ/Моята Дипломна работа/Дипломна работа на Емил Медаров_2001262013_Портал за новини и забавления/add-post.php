<?php
session_start();
include_once "config.php";
include_once "db.php";

$message = '';

// Function to fetch categories from the database
function getCategories($conn) {
    $stmt = $conn->prepare("SELECT category_id, category_name FROM categories");
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

if (isset($_SESSION['user']) && ($_SESSION['user']['userType'] === 'client' || $_SESSION['user']['userType'] === 'admin')) {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Получаване на данни от формата
    $user_id = $_SESSION['user']['user_id'] ?? '';
    $category_id = $_POST['category_id'] ?? '';
    $bulgaria_post_title = $_POST['bulgaria_post_title'] ?? '';
    $bulgaria_post_description = $_POST['bulgaria_post_description'] ?? '';
    $business_post_title = $_POST['business_post_title'] ?? '';
    $business_post_description = $_POST['business_post_description'] ?? '';
    $entertainment_post_title = $_POST['entertainment_post_title'] ?? '';
    $entertainment_post_description = $_POST['entertainment_post_description'] ?? '';
    $sport_post_title = $_POST['sport_post_title'] ?? '';
    $sport_post_description = $_POST['sport_post_description'] ?? '';
    $location_name = $_POST['location_name'] ?? '';
    $business_type = $_POST['business_type'] ?? '';
    $entertainment_type = $_POST['entertainment_type'] ?? '';
    $sport_type = $_POST['sport_type'] ?? '';

    // Защита срещу SQL инжекции с prepared statements
        if ($stmt = $conn->prepare("SELECT category_id FROM categories WHERE category_id = ?")) {
            $stmt->bind_param("i", $category_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Определяне на таблицата за вмъкване в зависимост от категорията
                switch ($category_id) {
                    case 1: // България
                        $bulgaria_post_photo = $_FILES['bulgaria_post_photo'] ?? null;
                        if ($bulgaria_post_photo && $bulgaria_post_photo['error'] === UPLOAD_ERR_OK) {
                            $imageData = file_get_contents($bulgaria_post_photo['tmp_name']);
                            $stmt = $conn->prepare("INSERT INTO bulgaria (bulgaria_post_photo, bulgaria_post_title, bulgaria_post_description, location_name, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("bsssii", $imageData, $bulgaria_post_title, $bulgaria_post_description, $location_name, $category_id, $user_id);
                            $stmt->send_long_data(0, $imageData);
                        }
                        break;
                    case 2: // Бизнес
                        $business_post_photo = $_FILES['business_post_photo'] ?? null;
                        if ($business_post_photo && $business_post_photo['error'] === UPLOAD_ERR_OK) {
                            $imageData = file_get_contents($business_post_photo['tmp_name']);
                            $stmt = $conn->prepare("INSERT INTO business (business_post_photo, business_post_title, business_post_description, business_type, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("bsssii", $imageData, $business_post_title, $business_post_description, $business_type, $category_id, $user_id);
                            $stmt->send_long_data(0, $imageData);
                        }
                        break;
                    case 3: // Забавления
                        $entertainment_post_photo = $_FILES['entertainment_post_photo'] ?? null;
                        if ($entertainment_post_photo && $entertainment_post_photo['error'] === UPLOAD_ERR_OK) {
                            $imageData = file_get_contents($entertainment_post_photo['tmp_name']);
                            $stmt = $conn->prepare("INSERT INTO entertainments (entertainment_post_photo, entertainment_post_title, entertainment_post_description, entertainment_type, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("bsssii", $imageData, $entertainment_post_title, $entertainment_post_description, $entertainment_type, $category_id, $user_id);
                            $stmt->send_long_data(0, $imageData);
                        }
                        break;
                    case 4: // Спорт
                        $sport_post_photo = $_FILES['sport_post_photo'] ?? null;
                        if ($sport_post_photo && $sport_post_photo['error'] === UPLOAD_ERR_OK) {
                            $imageData = file_get_contents($sport_post_photo['tmp_name']);
                            $stmt = $conn->prepare("INSERT INTO sport (sport_post_photo, sport_post_title, sport_post_description, sport_type, category_id, user_id) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param("bsssii", $imageData, $sport_post_title, $sport_post_description, $sport_type, $category_id, $user_id);
                            $stmt->send_long_data(0, $imageData);
                        }
                        break;
                    default:
                        $message = "Invalid category.";
                        break;
                }

                if (isset($stmt) && $stmt->execute()) {
                    $message = "Post created successfully.";
                } else {
                    $message = "Error: " . $stmt->error;
                }
            } else {
                $message = "Invalid category.";
            }
            $stmt->close();
        } else {
            $message = "Error: " . $conn->error;
        }

        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавяне на статия</title>
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <!-- <link rel="stylesheet" href="style.css"> -->
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
    top: 1350px;
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

    input[type="file"] {
        margin: 5px 0 20px 0;
    }

    /* span{
        color: darkred;
    } */

/* Стил за радио бутоните */
.radio-buttons {
    display: flex;
    flex-direction: column;
    color: black;
}

.radio-button {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    cursor: pointer;
}

.radio-button input[type="radio"] {
    display: none;
}

.radio-circle {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #aaa;
    position: relative;
    margin-right: 10px;
}

.radio-circle::before {
    content: "";
    display: block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #ddd;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: all 0.2s ease-in-out;
}

.radio-button input[type="radio"]:checked + .radio-circle::before {
    transform: translate(-50%, -50%) scale(1);
}

.radio-button.first input[type="radio"]:checked + .radio-circle::before {
    background-color: #023C40;
}

.radio-button.second input[type="radio"]:checked + .radio-circle::before {
    background-color: #A1B5D8;
}

.radio-button.third input[type="radio"]:checked + .radio-circle::before {
    background-color: #68A691;
}

.radio-button.fourth input[type="radio"]:checked + .radio-circle::before {
    background-color: #F5D6BA;
}

.radio-label {
    font-size: 16px;
    font-weight: bold;
    color: black;
}

.radio-button:hover .radio-circle {
    border-color: #555;
}

.radio-button:hover input[type="radio"]:checked + .radio-circle::before {
    background-color: #555;
}

.message-container p{
        font-size: 25px;
        font-weight: 500;
        color: darkred;
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

    <div class="form-container">
        <h2>Статия</h2>
        <form id="form" action="add-post.php" method="post" enctype="multipart/form-data">
            <label for="category_id">Категория статия:<span style="color:darkred">*</span></label><br>


            <?php
                    // Извличане на категориите от базата данни
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    $categories = getCategories($conn);
                    $colors = ['first', 'second', 'third', 'fourth'];
                    $i = 0;
                    while ($category = $categories->fetch_assoc()) {
                        $colorClass = $colors[$i % count($colors)];
                        echo '<div class="radio-buttons">';
                        echo '<label class="radio-button ' . $colorClass . '">';
                        echo '<input type="radio" name="category_id" value="' . $category['category_id'] . '" onclick="toggleFormType()">';
                        echo '<div class="radio-circle"></div>';
                        echo '<span class="radio-label">' . htmlspecialchars($category['category_name']) . '</span>';
                        echo '</label>';
                        echo '</div>';
                        $i++;
                    }
                    $conn->close();
                    ?>
            
            <div id="bulgaria-fields" style="display:block;">
            <h2>Добави статия в категория България</h2>
            <label for="bulgaria_post_photo">Добави снимка<span style="color:darkred">*</span></label><br>
            <input type="file" id="bulgaria_post_photo" name="bulgaria_post_photo" accept="image/*" ><br><br>

            <label for="bulgaria_post_title">Заглавие на статията:<span style="color:darkred">*</span></label><br>
            <input type="text" id="bulgaria_post_title" name="bulgaria_post_title"><br><br>

            <label for="bulgaria_post_description">Съдържание:<span style="color:darkred">*</span></label><br>
            <textarea id="bulgaria_post_description" name="bulgaria_post_description"></textarea><br><br>

            <label for="location_name">Тип на статията:<span style="color:darkred">*</span></label><br>
            <select id="location_name" name="location_name">
                <option value="София" name="София">София</option>
                <option value="Пловдив" name="Пловдив">Пловдив</option>
                <option value="Варна" name="Варна">Варна</option>
                <option value="Бургас" name="Бургас">Бургас</option>
                <option value="Стара Загора" name="Стара Загора">Стара Загора</option>
                <option value="Плевен" name="Плевен">Плевен</option>
                <option value="Русе" name="Русе">Русе</option>
                <option value="Велико Търново" name="Велико Търново">Велико Търново</option>
                <option value="Хасково" name="Хасково">Хасково</option>
                <option value="Кърджали" name="Кърджали">Кърджали</option>
            </select><br><br>
            </div>
            
            <div id="business-form" style="display:none;">
            <h2>Добави статия в категория Бизнес</h2>
            <label for="business_post_photo">Добави снимка<span style="color:darkred">*</span></label><br>
            <input type="file" id="business_post_photo" name="business_post_photo" accept="image/*"><br><br>

            <label for="business_post_title">Заглавие на статията:<span style="color:darkred">*</span></label><br>
            <input type="text" id="business_post_title" name="business_post_title"><br><br>

            <label for="business_post_description">Съдържание:<span style="color:darkred">*</span></label><br>
            <textarea id="business_post_description" name="business_post_description"></textarea><br><br>

            <label for="business_type">Тип на статията:<span style="color:darkred">*</span></label><br>
            <select id="business_type" name="business_type">
                <option value="Технологии" name="Технологии">Технологии</option>
                <option value="Автомобили" name="Автомобили">Автомобили</option>
            </select><br><br>
            </div>

            <div id="entertainment-form" style="display:none;">
            <h2>Добави статия в категория Забавления</h2>
            <label for="entertainment_post_photo">Добави снимка<span style="color:darkred">*</span></label><br>
            <input type="file" id="entertainment_post_photo" name="entertainment_post_photo" accept="image/*"><br><br>

            <label for="entertainment_post_title">Заглавие на статията:<span style="color:darkred">*</span></label><br>
            <input type="text" id="entertainment_post_title" name="entertainment_post_title"><br><br>

            <label for="entertainment_post_description">Съдържание:<span style="color:darkred">*</span></label><br>
            <textarea id="entertainment_post_description" name="entertainment_post_description"></textarea><br><br>

            <label for="entertainment_type">Тип на статията:<span style="color:darkred">*</span></label><br>
            <select id="entertainment_type" name="entertainment_type">
                <option value="Вицове" name="Вицове">Вицове</option>
                <option value="Хороскопи" name="Хороскопи">Хороскопи</option>
                <option value="Филми" name="Филми">Филми</option>
                <option value="Пътувания" name="Пътувания">Пътувания</option>
                <option value="Култура" name="Култура">Култура</option>
                <option value="Любопитно" name="Любопитно">Любопитно</option>
            </select><br><br>
            </div>

            <div id="sport-form" style="display:none;">
            <h2>Добави статия в категория Спорт</h2>
            <label for="sport_post_photo">Добави снимка<span style="color:darkred">*</span></label><br>
            <input type="file" id="sport_post_photo" name="sport_post_photo" accept="image/*"><br><br>

            <label for="sport_post_title">Заглавие на статията:<span style="color:darkred">*</span></label><br>
            <input type="text" id="sport_post_title" name="sport_post_title"><br><br>

            <label for="sport_post_description">Съдържание:<span style="color:darkred">*</span></label><br>
            <textarea id="sport_post_description" name="sport_post_description"></textarea><br><br>

            <label for="sport_type">Тип на статията:<span style="color:darkred">*</span></label><br>
            <select id="sport_type" name="sport_type">
                <option value="БГ Футбол" name="БГ Футбол">БГ Футбол</option>
                <option value="Баскетбол" name="Баскетбол">Баскетбол</option>
                <option value="Волейбол" name="Волейбол">Волейбол</option>
                <option value="Тенис" name="Тенис">Тенис</option>
            </select><br><br>
            </div>

        <button type="submit">Добави обявата</button>

        <?php if (!empty($message)) : ?>
            <div id="message" class="message-container">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>

        </form>
    </div>
    
    <footer>
        <p>&copy; 2024 Daily Brief</p>
    </footer>
    <script>
// Function to toggle the form type based on the selected category
function toggleFormType() {
    const categoryRadioButtons = document.getElementsByName('category_id');
    const bulgariaForm = document.getElementById('bulgaria-fields');
    const businessForm = document.getElementById('business-form');
    const entertainmentForm = document.getElementById('entertainment-form');
    const sportForm = document.getElementById('sport-form');

    // Hide all forms by default
    bulgariaForm.style.display = 'none';
    businessForm.style.display = 'none';
    entertainmentForm.style.display = 'none';
    sportForm.style.display = 'none';

    // Show the appropriate form based on the selected category
    for (let i = 0; i < categoryRadioButtons.length; i++) {
        if (categoryRadioButtons[i].checked) {
            const categoryId = categoryRadioButtons[i].value;
            if (categoryId == 1) {
                bulgariaForm.style.display = 'block';
            } else if (categoryId == 2) {
                businessForm.style.display = 'block';
            } else if (categoryId == 3) {
                entertainmentForm.style.display = 'block';
            } else if (categoryId == 4) {
                sportForm.style.display = 'block';
            }
            break;
        }
    }
}

// Initial call to set the correct form on page load
document.addEventListener('DOMContentLoaded', toggleFormType);

// Adding an event listener for form submission
document.getElementById('form').addEventListener('submit', function(event) {
    const categoryRadioButtons = document.getElementsByName('category_id');
    let formValid = false;

    for (let i = 0; i < categoryRadioButtons.length; i++) {
        if (categoryRadioButtons[i].checked) {
            formValid = true;
            break;
        }
    }

    if (!formValid) {
        event.preventDefault();
        alert('Моля, изберете категория преди да изпратите формата.');
    }
});

</script>

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
