<?php
session_start();
include_once "config.php"; // Конфигурационен файл за връзка с базата данни
include_once "db.php";

$message = "";

// Проверка дали формулярът е изпратен
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login']; // Потребителско име или имейл
    $password = $_POST['password'];

    // Проверка за потребител в базата данни
    $sql = "SELECT user_id, username, user_password, userType FROM Users WHERE username = ? OR user_email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $login, $login);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['user_password'])) {
                // Успешно влизане
                $_SESSION['user'] = [
                    'user_id' => $user['user_id'],
                    'username' => $user['username'],
                    'userType' => $user['userType'],
                    'login_time' => date('Y-m-d H:i:s')
                ];

                // Проверка на "Запомни ме"
                if (isset($_POST['remember_me'])) {
                    // Създаване на бисквитка за запомняне
                    setcookie('username', $user['username'], time() + (86400 * 30), "/"); // 30 дни
                } else {
                    // Изтриване на бисквитката, ако "Запомни ме" не е избрано
                    setcookie('username', '', time() - 3600, "/"); // Изтриване на бисквитката
                }
                header("Location: index.php");
                exit();
            } else {
                $message = "Невалидна парола.";
            }
        } else {
            $message = "Потребителят не съществува.";
        }
        $stmt->close();
    } else {
        $message = "Грешка при подготовката на заявката: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Влизане в системата</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="icon" href="image/png" href="ïmages/icon-for-the-portal.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/icon-for-the-portal.png" sizes="32x32">
    <link rel="shortcut icon" type="image/x-icon" href="images/icon-for-the-portal.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/icon-for-the-portal.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body onload="hideMessage()">
<script>
        function hideMessage() {
            setTimeout(function() {
                document.getElementById("message").style.display = "none";
            }, 15000); // 15 секунди
        }
    </script>
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
        color:#F2F6D0;
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
    top: 600px;
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
    .remember-me-container{
            display: flex;
            align-items: center;
    }
    .remember-me {
    display: flex;
    align-items: center;
    margin-right: 275px;
    }

    .remember-me #remember_me[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #30cfd0;
    border-radius: 5px;
    background-color: transparent;
    display: inline-block;
    position: relative;
    margin-right: 10px;
    cursor: pointer;
    }

    .remember-me #remember_me[type="checkbox"]:before {
    content: "";
    background-color: #30cfd0;
    display: block;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    width: 10px;
    height: 10px;
    border-radius: 3px;
    transition: all 0.3s ease-in-out;
    }

    .remember-me #remember_me[type="checkbox"]:checked:before {
    transform: translate(-50%, -50%) scale(1);
    }

    .remember-me label {
    font-size: 18px;
    color: #fff;
    cursor: pointer;
    user-select: none;
    display: flex;
    align-items: center;
    }

    .forgot-password {
    font-size: 16px;
    color: #30cfd0; 
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
    }

    .forgot-password:hover {
    color: #fff;
    }

    span{
        color: darkred;
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
    <h2>Вход</h2>
    <form id="form" action="login.php" method="post">
        <label for="login">Потребителско име или имейл: <span>*</span></label>
        <input type="text" id="login" name="login" required>

        <label for="password">Парола:<span>*</span></label>
        <input type="password" id="password" name="password" required>
    <div class="remember-me-container">
        <div class="remember-me">
            <input type="checkbox" id="remember_me" name="remember_me">
            <label for="remember_me">Запомни ме</label>
        </div>

        <a href="forgot_password.php" class="forgot-password">Забравена парола?</a>
    </div>
        <button type="submit">Вход</button>

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
