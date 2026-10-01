<?php
// Включване на конфигурационния файл
include_once "config.php";

// Функция за изпълнение на SQL заявки
function execute_query($sql) {
    global $conn;
    return $conn->query($sql);
}
?>