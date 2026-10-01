<?php
session_start();
include_once "config.php";
// Debug session content
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Портал за новини и забавления</title>
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <link rel="stylesheet" href="styles/style-for-homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
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
        <h1 id="heading">Здравей и добре дошъл в Daily Brief!</h1>
        <p id="paragraph">Тук е мястото, където ще откриеш всичко необходимо, за да си в крак с нещата, като ще имаш възможност да качваш статии, както и да играеш игри!</p>
    </header>
    

    <footer>
        <p>&copy; 2024 Daily Brief</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector('form');

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
